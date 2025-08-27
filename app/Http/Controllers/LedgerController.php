<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\University;
use App\Models\Course;
use App\Models\Ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Helpers\InvoiceHelper;


class LedgerController extends Controller
{
    public function getStudenLedgers(){
        $role = Auth::guard('webadmin')->user()->roles;
        $user_id = Auth::guard('webadmin')->user()->id;
        if($role == 'Admin' || $role == 'Manager'){
            $ledgers = Ledger::leftJoin('students', 'students.id', '=', 'ledgers.student_id')
            ->groupBy('student_id')
            ->orderByDesc('ledgers.id') // 👈 added for DESC order
            ->get();
        }else{
            $ledgers = Ledger::leftJoin('students', 'students.id', '=', 'ledgers.student_id')
            ->groupBy('student_id')
            ->where('students.owner_id', $user_id)
             ->orderByDesc('ledgers.id') // 👈 added for DESC order
            ->get();
        }
        return view('form.ledgers.index',compact('ledgers'));
    }

    public function getStudentFee($id=null){
        $ledgers = Ledger::leftJoin('students', 'students.id', '=', 'ledgers.student_id')
        ->where('student_id', $id)
        ->orderBY('ledgers.id', 'DESC')
        ->first();
        return view('form.ledgers.ajax.get-fee',compact('ledgers'));
    }

    public function addpayment(Request $request){
        $ledger_check = Ledger::where('student_id', $request->id)->first();
        if($ledger_check){
            // handle file upload
        $fileName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('admin/attachement'), $fileName);
        }
            $ledger = Ledger::insertGetId([
                'student_id'=> $request->id,
                'provided_transaction_id' => $request->provided_transaction_id,
                'transaction_id'=> Str::random(7),
                'fee_received'=> $request->received_fee,
                // 'due_ammount'=> ($request->due_fee - $request->received_fee),
                'due_ammount'=> ($request->due_fee),
                'status' => ($request->due_fee - $request->received_fee == 0) ? 1 : 2,
                'file' => $fileName, // save filename in DB
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
            if($ledger){
                return ['status'=>'200', 'msg'=>'payment update successfully!'];
            }
        }else{
            return ['status'=>'400', 'msg'=>'student no found!'];
        }
    }


    public function getFeeDetails($id)
{
    $ledger = Ledger::with('student')->findOrFail($id);

    return view('form.ledgers.modalforview', compact('ledger'));
}

// public function updateFeeStatus(Request $request, $id)
// {
//     $ledger = Ledger::findOrFail($id);
//     $ledger->approval_status = $request->status;
//     $ledger->save();

//     return response()->json(['success' => true]);
// }




// public function updateFeeStatus(Request $request, $id)
// {
//     $ledger = Ledger::findOrFail($id);

//     // Update the status (1 = approved, 2 = rejected, 0 = pending)
//     $ledger->approval_status = $request->status;
//     $ledger->save();

//     // Get the student
//     $student = Student::findOrFail($ledger->student_id);

//     // Sum of approved payments only
//     $approvedReceived = Ledger::where('student_id', $ledger->student_id)
//         ->where('approval_status', 1)
//         ->sum('fee_received');

//     // Calculate new due
//     $newDue = $student->total_fee - $approvedReceived;

//     // Update due_amount on all ledgers of this student
//     Ledger::where('student_id', $ledger->student_id)->update(['due_ammount' => $newDue]);

//     return response()->json(['success' => true, 'new_due' => $newDue]);
// }




// 26/08/2025

// public function updateFeeStatus(Request $request, $id)
// {
//     $ledger = Ledger::findOrFail($id);

//     // Update the status (1 = approved, 2 = rejected, 0 = pending)
//     $ledger->approval_status = $request->status;
//     $ledger->save();

//     // Get the student
//     $student = Student::findOrFail($ledger->student_id);

//     // Sum of approved payments only
//     $approvedReceived = Ledger::where('student_id', $ledger->student_id)
//         ->where('approval_status', 1)
//         ->sum('fee_received');

//     // Calculate new due
//     $newDue = $student->total_fee - $approvedReceived;

//     // ✅ Update due_amount only for this particular ledger
//     $ledger->due_ammount = $newDue;
//     $ledger->save();

//     return response()->json([
//         'success' => true,
//         'new_due' => $newDue
//     ]);
// }

// public function updateFeeStatus(Request $request, $id)
// {
//     $ledger = Ledger::findOrFail($id);

//     // Update the status (1 = approved, 2 = rejected, 0 = pending)
//     $ledger->approval_status = $request->status;
//     $ledger->save();

//     // Get the student
//     $student = Student::findOrFail($ledger->student_id);

//     // Sum of approved payments only
//     $approvedReceived = Ledger::where('student_id', $ledger->student_id)
//         ->where('approval_status', 1)
//         ->sum('fee_received');

//     // Calculate new due
//     $newDue = $student->total_fee - $approvedReceived;

//     // ✅ Update due_amount only for this particular ledger
//     $ledger->due_ammount = $newDue;
//     $ledger->save();

//     // ---------------------------------
//     // ✅ Email notification logic (No PDF Attach)
//     // ---------------------------------
//     try {
//         if ($ledger->approval_status == 1) {
//             // Approved → send approval mail
//             Mail::send('emails.fee_approved', [
//                 'student' => $student,
//                 'ledger' => $ledger,
//                 'newDue' => $newDue
//             ], function ($message) use ($student) {
//                 $message->to($student->email, $student->name)
//                     ->subject('✅ Fee Payment Approved');
//             });

//         } elseif ($ledger->approval_status == 2) {
//             // Rejected → send rejection mail
//             Mail::send('emails.fee_rejected', [
//                 'student' => $student,
//                 'ledger' => $ledger
//             ], function ($message) use ($student) {
//                 $message->to($student->email, $student->name)
//                     ->subject('❌ Fee Payment Rejected');
//             });
//         }
//     } catch (\Exception $e) {
//         Log::error("Mail not sent: " . $e->getMessage());
//     }

//     return response()->json([
//         'success' => true,
//         'new_due' => $newDue
//     ]);
// }
// public function updateFeeStatus(Request $request, $id)
// {
//     $ledger = Ledger::findOrFail($id);

//     // Update the status (1 = approved, 2 = rejected, 0 = pending)
//     $ledger->approval_status = $request->status;
//     $ledger->save();

//     // Get the student
//     $student = Student::findOrFail($ledger->student_id);

//     // Sum of approved payments only
//     $approvedReceived = Ledger::where('student_id', $ledger->student_id)
//         ->where('approval_status', 1)
//         ->sum('fee_received');

//     // Calculate new due
//     $newDue = $student->total_fee - $approvedReceived;

//     // ✅ Update due_amount only for this particular ledger
//     $ledger->due_ammount = $newDue;
//     $ledger->save();

//     try {
//         if ($ledger->approval_status == 1) {
//             // ✅ Generate PDF and save temporarily
//             $pdfPath = storage_path('app/public/PV-' . $student->name . '-Invoice.pdf');

//             InvoiceHelper::generateInvoicePdf($ledger->id, $pdfPath);

//             // ✅ Send email with PDF attachment
//             Mail::send('emails.fee_approved', [
//                 'student' => $student,
//                 'ledger' => $ledger,
//                 'newDue' => $newDue
//             ], function ($message) use ($student, $pdfPath) {
//                 $message->to($student->email, $student->name)
//                         ->subject('✅ Fee Payment Approved')
//                         ->attach($pdfPath);
//             });

//             // ✅ Delete temporary PDF file after sending
//             if (file_exists($pdfPath)) {
//                 unlink($pdfPath);
//             }
//         }
//     } catch (\Exception $e) {
//         Log::error("Mail not sent: " . $e->getMessage());
//     }

//     return response()->json([
//         'success' => true,
//         'new_due' => $newDue
//     ]);
// }

public function updateFeeStatus(Request $request, $id)
{
    $ledger = Ledger::findOrFail($id);

    // Update the status (1 = approved, 2 = rejected, 0 = pending)
    $ledger->approval_status = $request->status;
    $ledger->save();

    // Get the student
    $student = Student::findOrFail($ledger->student_id);

    // Sum of approved payments only
    $approvedReceived = Ledger::where('student_id', $ledger->student_id)
        ->where('approval_status', 1)
        ->sum('fee_received');

    // Calculate new due
    $newDue = $student->total_fee - $approvedReceived;

    // Update due_amount only for this particular ledger
    $ledger->due_ammount = $newDue;
    $ledger->save();

    try {
        if ($ledger->approval_status == 1) {
            // ✅ Check if this is the first ledger entry
            $firstLedger = Ledger::where('student_id', $ledger->student_id)
                                 ->orderBy('id', 'asc')
                                 ->first();

            if ($ledger->id != $firstLedger->id) {
                // ✅ Not first ledger → send Fee Approved email
                $pdfPath = storage_path('app/public/PV-' . $student->name . '-Invoice.pdf');
                InvoiceHelper::generateInvoicePdf($ledger->id, $pdfPath);

                Mail::send('emails.fee_approved', [
                    'student' => $student,
                    'ledger' => $ledger,
                    'newDue' => $newDue
                ], function ($message) use ($student, $pdfPath) {
                    $message->to($student->email, $student->name)
                            ->subject('✅ Fee Payment Approved')
                            ->attach($pdfPath);
                });

                // Delete temporary PDF file after sending
                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }
            }
            // ✅ If first ledger → skip mail, welcome mail already sent
        }
    } catch (\Exception $e) {
        Log::error("Mail not sent: " . $e->getMessage());
    }

    return response()->json([
        'success' => true,
        'new_due' => $newDue
    ]);
}







// public function sendMailBasedOnLedger($ledgerId)
// {
//     $ledger = Ledger::findOrFail($ledgerId);
//     $student = Student::findOrFail($ledger->student_id);

//     // Skip if ledger is pending or rejected
//     // if ($ledger->approval_status == 0) {
//     //     return response()->json(['success' => false, 'message' => 'Payment is pending, mail not sent']);
//     // }
//     // if ($ledger->approval_status == 2) {
//     //     return response()->json(['success' => false, 'message' => 'Payment is rejected, mail not sent']);
//     // }

//     // Determine if this is the first ledger entry
//     $firstLedger = Ledger::where('student_id', $ledger->student_id)
//         ->orderBy('id', 'asc')
//         ->first();

//     try {
//         $pdfPath = storage_path('app/public/PV-' . $student->name . '-Invoice.pdf');
//         InvoiceHelper::generateInvoicePdf($ledger->id, $pdfPath);

//         if ($ledger->id == $firstLedger->id) {
//             // First entry → Welcome Mail
//             $data = ['student' => $student, 'ledger' => $ledger];
//             Mail::send('emails.welcome', $data, function ($message) use ($student, $pdfPath) {
//                 $message->to($student->email, $student->name)
//                         ->subject("🎓 Welcome to Rudra ACK Solutions – Your Learning Journey Begins!");
//                 if (file_exists($pdfPath)) {
//                     $message->attach($pdfPath, ['as' => basename($pdfPath), 'mime' => 'application/pdf']);
//                 }
//             });
//             $message = 'Welcome mail sent successfully';
//         } else {
//             // Other entries → Fee Approved Mail
//             $approvedReceived = Ledger::where('student_id', $ledger->student_id)
//                 ->where('approval_status', 1)
//                 ->sum('fee_received');
//             $newDue = $student->total_fee - $approvedReceived;

//             $ledger->due_ammount = $newDue;
//             $ledger->save();

//             $data = ['student' => $student, 'ledger' => $ledger, 'newDue' => $newDue];
//             Mail::send('emails.fee_approved', $data, function ($message) use ($student, $pdfPath) {
//                 $message->to($student->email, $student->name)
//                         ->subject('✅ Fee Payment Approved');
//                 if (file_exists($pdfPath)) {
//                     $message->attach($pdfPath, ['as' => basename($pdfPath), 'mime' => 'application/pdf']);
//                 }
//             });
//             $message = 'Fee approved mail sent successfully';
//         }

//         // Delete temporary PDF
//         if (file_exists($pdfPath)) {
//             unlink($pdfPath);
//         }

//         return response()->json(['success' => true, 'message' => $message]);

//     } catch (\Exception $e) {
//         return response()->json(['success' => false, 'message' => $e->getMessage()]);
//     }
// }





}
