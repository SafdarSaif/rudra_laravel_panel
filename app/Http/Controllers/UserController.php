<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ledger;
use App\Models\Student;
use App\Models\University;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Rmunate\Utilities\SpellNumber;
use DB;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;


class UserController extends Controller
{
    public function dashboard(){
        $role = Auth::guard('webadmin')->user()->roles;
        $user_id = Auth::guard('webadmin')->user()->id;
        $total_ammount = 0;
        $total_received_ammount = 0;
        $total_due = 0;
        if($role == 'Admin' || $role == 'Manager'){
            $ledgers = Ledger::select(DB::raw("SUM(fee_received) as received_amt"))->get();
            $total_amts = Student::select(DB::raw("SUM(total_fee) as total_amt"))->get();
            foreach($total_amts as $total_amt){
                $total_ammount = $total_amt->total_amt;
            }
            foreach($ledgers as $ledger){
                $total_received_ammount = $ledger->received_amt;
            }
            $total_due = $total_ammount - $total_received_ammount;
        }else{
            $ledgers = Ledger::select(DB::raw("SUM(fee_received) as received_amt"))
            ->leftJoin('students', 'students.id', '=', 'ledgers.student_id')
            ->where('students.owner_id', $user_id)
            ->get();

            $total_amts = Student::select(DB::raw("SUM(total_fee) as total_amt"))->where('owner_id', $user_id)->get();
            foreach($total_amts as $total_amt){
                $total_ammount = $total_amt->total_amt;
            }
            foreach($ledgers as $ledger){
                $total_received_ammount = $ledger->received_amt;
            }

            $total_due = $total_ammount - $total_received_ammount;

        }
        return view('dashboard', compact('ledgers', 'total_due', 'total_received_ammount', 'total_ammount'));
    }
    public function index()
    {
        $users = User::all();
        return view('user', compact('users'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'roles' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $users = new User;
            $users->name = $validated['name'];
            $users->email = $validated['email'];
            $users->roles = $validated['roles'];
            $users->password = Hash::make($validated['password']);
            $users->save();
            return ['status' => '200', 'msg' => 'users Created successfully!'];
        } catch (\Exception $e) {
            return response()->json(['status' => $e, 'msg' => $users]);
        }
    }

    public function edit($User)
    {
        $User = User::findOrFail($User);
        return view('form.user.edit', compact('User'));
    }


    public function update($user_id, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'roles' => 'required|string',
        ]);

        try {
            $user = User::findOrFail($user_id);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->roles = $validated['roles'];
            if ($request->password) {
                $user->password = Hash::make($validated['password']);
            } else {
                $user->password = $user->password;
            }
            $user->save();
            return ['status' => '200', 'msg' => 'user Updated successfully!'];
        } catch (\Exception $e) {
            return response()->json(['status' => $e, 'msg' => $user]);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete($id);
        return ['status' => '200', 'msg' => 'content deleted successfully!'];
    }

    public function changeUser(Request $request){
        $user_check = User::find($request->id);
        if($user_check){
            $status_change = User::where('id', $request->id)->update([
                "status" => $request->status == 'active' ? 0 : 1
            ]);

            if($status_change){
                return ['status' => '200', 'msg' => 'status changed now'];
            }else{
                return ['status' => '400', 'msg' => 'error '];
            }
        }
    }

    // public function downloadUserPdf($request){
    //     $student_data = Ledger::where('id', $request)->first();
    //     $student = Student::select('students.*', 'courses.name as course_name')
    //         ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
    //         ->where('students.id', $student_data->student_id)
    //         ->first();
    //     $university = University::select('name as uni_name')
    //             ->where('id', $student->university_id)
    //             ->first();
    //     $total_fee = 0;
    //     $total_fee = $student->total_fee;
    //     $received_fee = 0;
    //     $received_fee =  $received_fee + $student_data->fee_received;
    //     // $due_fee = $student->total_fee - $received_fee;
    //     $feeinwords = SpellNumber::value($received_fee)->locale('en')->toLetters();
    //     $pdf = new Fpdi();

    //     // add a page
    //     $pdf->AddPage();
    //     $pdf->setSourceFile(base_path('public/admin/pdf/Pv-Invoice.pdf'));
    //     // $tplId = $pdf->importPage(1);
    //     // $pdf->useTemplate($tplId, 0, 0, 100);
    //     $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
    //     // $pdf->addPage();
    //     $pdf->useImportedPage($pageId, 0, 0, 210);
    //     $pdf->SetFont('Arial','',11);
    //     // $pdf->SetFont('Arial', 'B', 11);

    //     //Name
    //     $pdf->SetXY(50, 72);
    //     $pdf->Write(1, $student->name);

    //     // Course Name
    //     $pdf->SetXY(45, 82);
    //     $pdf->Write(1, $student->course_name);

    //     // SubCourse Name
    //     $pdf->SetXY(45, 91.5);
    //     $pdf->Write(1, $student->sub_course);

    //     // University name
    //     $pdf->SetXY(50, 101.5);
    //     $pdf->Write(1, $university->uni_name);

    //     // University name
    //     $pdf->SetXY(154, 101.5);
    //     $pdf->Write(1, $student->sem_year);


    //     // Fee Section
    //     $pdf->SetXY(150, 155.5);
    //     $pdf->Write(1, $received_fee."/INR");
    //     $pdf->SetXY(35, 193.5);
    //     $pdf->Write(1, "Ruppes ".$feeinwords." Only");

    //     //DATE
    //     $pdf->SetXY(47, 58);
    //     $pdf->Write(1, $student_data->student_id.'/'.$student_data->created_at->format('Y'));
    //     $pdf->SetXY(131, 58);
    //     $pdf->Write(1, $student_data->created_at->format('d-m-Y'));
    //     $pdf->SetXY(69, 169.5);
    //     $pdf->Write(1, $student->favour);
    //     $pdf->SetXY(150, 120.5);
    //     $pdf->Write(1, $received_fee.'/-');
    //     $pdf->SetXY(43, 181.5);
    //     $pdf->Write(1, $student_data->provided_transaction_id ? $student_data->provided_transaction_id : "NA" );

    //     // Page 2
    //     // $pageId = $pdf->importPage(2, PdfReader\PageBoundaries::MEDIA_BOX);
    //     // $pdf->addPage();
    //     // $pdf->useImportedPage($pageId, 0, 0, 210);


    //     // Page 3
    //     // $pageId = $pdf->importPage(3, PdfReader\PageBoundaries::MEDIA_BOX);
    //     // $pdf->addPage();
    //     // $pdf->useImportedPage($pageId, 0, 0, 210);

    //     $pdf->Output('D', 'PV-'.$student->name.'-Invoice.pdf');
    //     exit();
    // }
    public function downloadUserPdf($request){
        $student_data = Ledger::where('id', $request)->first();
        $student = Student::select('students.*', 'courses.name as course_name')
            ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
            ->where('students.id', $student_data->student_id)
            ->first();
        $university = University::select('name as uni_name')
                ->where('id', $student->university_id)
                ->first();
        $total_fee = 0;
        $total_fee = $student->total_fee;
        $received_fee = 0;
        $received_fee =  $received_fee + $student_data->fee_received;
        $due_fee = $student->total_fee - $received_fee;
        $feeinwords = SpellNumber::value($received_fee)->locale('en')->toLetters();
        $pdf = new Fpdi();
        // dd($student);
        // add a page
        $pdf->AddPage();
        $pdf->setSourceFile(base_path('public/admin/pdf/edufinal.pdf'));
        // $tplId = $pdf->importPage(1);
        // $pdf->useTemplate($tplId, 0, 0, 100);
        $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
        // $pdf->addPage();
        $pdf->useImportedPage($pageId, 0, 0, 210);
        $pdf->SetFont('Arial','',11);
        // $pdf->SetFont('Arial', 'B', 11);

        //Name
        $pdf->SetXY(60, 86);
        $pdf->Write(1, $student->name);

        // Course Name
        $pdf->SetXY(54, 96);
        $pdf->Write(1, $student->father_name);

        // SubCourse Name
        $pdf->SetXY(54, 105);
        $pdf->Write(1, $student->course_name);

        // University name
        $pdf->SetXY(48, 92);
        // $pdf->Write(1, $university->sub_course);

        // University name
        // $pdf->SetXY(154, 101.5);
        // $pdf->Write(1, $student->sem_year);


        // Fee Section
        $pdf->SetXY(160, 168);
        $pdf->Write(1, $total_fee."/INR");
        $pdf->SetXY(176, 176);
        $pdf->Write(1, $due_fee);
        $pdf->SetXY(35, 193.5);
        // $pdf->Write(1, "Ruppes ".$feeinwords." Only");

        //DATE
        $pdf->SetXY(47, 78);
        $pdf->Write(1, $student_data->student_id.'/'.$student_data->created_at->format('Y'));
        $pdf->SetXY(133, 78);
        $pdf->Write(1, $student_data->created_at->format('d-m-Y'));
        $pdf->SetXY(150, 196.5);
        $pdf->Write(1, $student_data->transaction_id);
        $pdf->SetXY(160, 139);
        $pdf->Write(1, $received_fee.'/-');
        $pdf->SetXY(55, 196.5);
        $pdf->Write(1, $student_data->mode );

        // Page 2
        // $pageId = $pdf->importPage(2, PdfReader\PageBoundaries::MEDIA_BOX);
        // $pdf->addPage();
        // $pdf->useImportedPage($pageId, 0, 0, 210);


        // Page 3
        // $pageId = $pdf->importPage(3, PdfReader\PageBoundaries::MEDIA_BOX);
        // $pdf->addPage();
        // $pdf->useImportedPage($pageId, 0, 0, 210);

        $pdf->Output('I', 'PV-'.$student->name.'-Invoice.pdf');
        exit();
    }
}
