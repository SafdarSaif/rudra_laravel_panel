<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\University;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Ledger;
use App\Models\Acadmics;
use DB;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Helpers\InvoiceHelper;

class StudentController extends Controller
{



    // public function sendWelcomeMail($id)
    // {
    //     $student = Student::find($id);
    //     $ledger  = Ledger::where('student_id', $id)->latest()->first();

    //     if (!$student) {
    //         return response()->json(['success' => false, 'message' => 'Student not found']);
    //     }

    //     try {
    //         $filePath = null;
    //         if ($ledger && $ledger->file) {
    //             $filePath = public_path('admin/attachement/' . $ledger->file);
    //         }

    //         $data = [
    //             'student' => $student,
    //             'ledger' => $ledger
    //         ];

    //         Mail::send('emails.welcome', $data, function ($message) use ($student, $filePath) {
    //             $message->to($student->email, $student->name)
    //                 ->subject("🎓 Welcome to Rudra ACK Solutions – Your Learning Journey Begins!");

    //             if ($filePath && file_exists($filePath)) {
    //                 $message->attach($filePath);
    //             }
    //         });

    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    public function sendWelcomeMail($id)
    {
        // Fetch student details along with the associated course name
        $student = Student::select('students.*', 'courses.name as course_name')
            ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
            ->where('students.id', $id)
            ->first();

        // Retrieve the student's first (oldest) ledger entry
        $ledger = Ledger::where('student_id', $id)->orderBy('id', 'asc')->first();

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found']);
        }

        // Skip mail sending if no ledger exists, or if payment is pending (0) or rejected (2)
        if (!$ledger) {
            return response()->json(['success' => false, 'message' => 'No ledger entry found, mail not sent']);
        }
        if ($ledger->approval_status == 0) {
            return response()->json(['success' => false, 'message' => 'Payment is pending, mail not sent']);
        }
        if ($ledger->approval_status == 2) {
            return response()->json(['success' => false, 'message' => 'Payment is rejected, mail not sent']);
        }

        try {
            // Generate invoice PDF only if the payment is approved (1)
            $pdfPath = null;
            if ($ledger->approval_status == 1) {
                $pdfPath = storage_path('app/public/PV-' . $student->name . '-Invoice.pdf');
                InvoiceHelper::generateInvoicePdf($ledger->id, $pdfPath);
            }

            $data = [
                'student' => $student,
                'ledger'  => $ledger,
            ];

            // Send the welcome email with the invoice attached (if applicable)
            Mail::send('emails.welcome', $data, function ($message) use ($student, $pdfPath) {
                $message->to($student->email, $student->name)
                    ->subject("🎓 Welcome to Rudra ACK Solutions – Your Learning Journey Begins!");

                // Attach the generated invoice PDF if available
                if ($pdfPath && file_exists($pdfPath)) {
                    $message->attach($pdfPath, [
                        'as'   => basename($pdfPath),
                        'mime' => 'application/pdf'
                    ]);
                }
            });

            // Delete the temporary PDF after the email has been sent
            if ($pdfPath && file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            return response()->json(['success' => true, 'message' => 'Mail sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }







    public function index()
    {
        $role = Auth::guard('webadmin')->user()->roles;
        $user_id = Auth::guard('webadmin')->user()->id;
        if ($role == 'Admin' || $role == 'Manager') {
            $students = Student::select('students.*', 'universities.name as unversity_name', 'courses.name as course_name')
                ->leftJoin('universities', 'universities.id', '=', 'students.university_id')
                ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
                ->groupBy('students.name')
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $students = Student::select('students.*', 'universities.name as unversity_name', 'courses.name as course_name')
                ->leftJoin('universities', 'universities.id', '=', 'students.university_id')
                ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
                ->groupBy('students.name')
                ->orderBy('id', 'DESC')
                ->where('students.owner_id', $user_id)
                ->get();
        }
        return view('student', compact('students'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'university_id' => 'required|string',
            'course_id' => 'required|string',
            'session' => 'required|string',
            'dob' => 'required|string',
            'total_fee' => 'required|string',
            'registration_fee' => 'required|string',
            'owner_id' => 'required',
            'sem_year' => 'required',
            'favour' => 'required',
            'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
             'mode' => 'required|string'// ✅ added mode validation
        ]);

        $check_new_student = Student::where('email', $request->email)->where('phone', $request->phone)->first();
        if ($check_new_student) {
            return ['status' => '400', 'msg' => 'student already exist!'];
        }

        try {
            $student = new Student;
            $student->name = $validated['name'];
            $student->owner_id = $validated['owner_id'];;
            $student->email = $validated['email'];
            $student->phone = $validated['phone'];
            $student->university_id = $validated['university_id'];
            $student->course_id = $validated['course_id'];
            $student->sub_course = $request->sub_course;
            $student->sem_year = $validated['sem_year'];
            $student->session = $validated['session'];
            $student->dob = $validated['dob'];
            $student->total_fee = $validated['total_fee'];
            $student->favour = $validated['favour'];
            $student->registration_fee = $validated['registration_fee'];

            $student_saved = $student->save();

            // handle file upload
            $fileName = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('admin/attachement'), $fileName);
            }

            //Create Ledgers
            if ($student_saved) {
                Ledger::insertGetId([
                    'student_id' => $student->id,
                    'provided_transaction_id' => $request->provided_transaction_id,
                    'transaction_id' => Str::random(7),
                    'fee_received' => $student->registration_fee,
                    'due_ammount' => ($student->total_fee),
                    // 'due_ammount'=> ($student->total_fee - $student->registration_fee),
                    'status' => ($student->total_fee - $student->registration_fee == 0) ? 1 : 2,
                    'file' => $fileName, // ✅ store file name in ledger
                    'mode' => $validated['mode'], // ✅ store mode in ledger
                    'created_at' => now(),
                    'updated_at' => now(),

                ]);
            }
            return ['status' => '200', 'msg' => 'student punch successfully!'];
        } catch (\Exception $e) {
            return response()->json(['status' => $e, 'msg' => $student]);
        }
    }

    public function edit($student)
    {
        $student = Student::where('id', $student)->first();
        $courses = Course::get();
        $unis = University::get();
        return view('form.student.edit', compact('student', 'courses', 'unis'));
    }


    public function update($student_id, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'university_id' => 'required|string',
            'course_id' => 'required|string',
            'session' => 'required|string',
            'dob' => 'required|string',
            'total_fee' => 'required|string',
            'registration_fee' => 'required|string',
        ]);

        try {
            $student = Student::findOrFail($student_id);
            $student->name = $validated['name'];
            $student->owner_id = Auth::guard('webadmin')->user()->id;
            $student->email = $validated['email'];
            $student->phone = $validated['phone'];
            $student->university_id = $validated['university_id'];
            $student->course_id = $validated['course_id'];
            $student->sub_course = $request->sub_course;
            $student->session = $validated['session'];
            $student->dob = $validated['dob'];
            $student->total_fee = $validated['total_fee'];
            $student->registration_fee = $validated['registration_fee'];
            $student->save();
            return ['status' => '200', 'msg' => 'Student Updated successfully!'];
        } catch (\Exception $e) {
            return response()->json(['status' => $e, 'msg' => $student]);
        }
    }

    public function destroy($id)
    {
        $student_ladgers = Ledger::where('student_id', $id)->first();
        if ($student_ladgers) {
            return ['status' => '300', 'msg' => 'Student exist in ladgers!'];
        } else {
            $student = Student::find($id);
            $student->delete($id);
            return ['status' => '200', 'msg' => 'content deleted successfully!'];
        }
    }




    public function downloadForm($student_id = null)
    {
        $student_data = Acadmics::where('student_id', $student_id)->first();
        $student = Student::select('students.*', 'courses.name as course_name')
            ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
            ->where('students.id', $student_id)
            ->first();
        $university = University::select('name as uni_name')
            ->where('id', $student->university_id)
            ->first();


        $pdf = new Fpdi();
        if ($university->uni_name == "SVSU") {
            $pdf->setSourceFile(base_path('public/admin/pdf/svsu_student_form.pdf'));
            $pdf->addPage();
            $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
            $pdf->useImportedPage($pageId, 0, 0, 210);
            $pdf->SetFont('Arial', '', 11);

            //OA NUMBER
            $pdf->SetXY(27.5, 57);
            $pdf->Write(1, "PV-0011");

            //Aplication NUMBER
            $pdf->SetXY(101, 57);
            $pdf->Write(1, "PV-0011");

            //Session
            $pdf->SetXY(166, 57);
            $pdf->Write(1, $student->session);

            // Student Photo
            $pdf->Image(base_path('public/admin/student_photo/' . $student_data->photo), 173.5, 61.5, 25.5, 25.9);


            //Centercode
            $pdf->SetXY(46.5, 74.5);
            $pdf->Write(1, 3031);

            // Course Name
            $pdf->SetXY(74.5, 102);
            $pdf->Write(1, $student->course_name . ' (' . $student->sub_course . ')');

            //Name
            $pdf->SetXY(14.5, 117);
            $pdf->Write(1, $student->name);

            //Father Name
            $pdf->SetXY(14.5, 130);
            $pdf->Write(1, $student_data->father_name);

            //Mother Name
            $pdf->SetXY(14.5, 143.5);
            $pdf->Write(1, $student_data->mother_name);

            // Gender
            if ($student_data->gender == 'Male') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 58, 160.5, 3, 3);
            } else {
                $pdf->Image(base_path('public/admin/images/checked.png'), 73, 160.5, 3, 3);
            }

            //DOB
            $d = new DateTime($student_data->dob);
            $pdf->SetXY(145, 161.5);
            $pdf->Write(1, $d->format('d'));
            $pdf->SetXY(160, 161.5);
            $pdf->Write(1, $d->format('m'));
            $pdf->SetXY(178, 161.5);
            $pdf->Write(1, $d->format('Y'));

            // pincode
            $explode_id = str_split($student_data->pincode);
            $pdf->SetXY(149, 187.5);
            $pdf->Write(1, $explode_id['0']);
            $pdf->SetXY(159, 187.5);
            $pdf->Write(1, $explode_id['1']);
            $pdf->SetXY(167, 187.5);
            $pdf->Write(1, $explode_id['2']);
            $pdf->SetXY(175, 187.5);
            $pdf->Write(1, $explode_id['3']);
            $pdf->SetXY(183, 187.5);
            $pdf->Write(1, $explode_id['4']);
            $pdf->SetXY(192, 187.5);
            $pdf->Write(1, $explode_id['5']);

            // mobile
            $pdf->SetXY(75, 201.5);
            $pdf->Write(1, $student->phone);

            // email
            $pdf->SetXY(135, 201.5);
            $pdf->Write(1, $student->email);
        } else if ($university->uni_name == "BOSSE") {
            $pdf->setSourceFile(base_path('public/admin/pdf/bosse_student_form.pdf'));
            $pdf->addPage();
            $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
            $pdf->useImportedPage($pageId, 0, 0, 210);
            $pdf->SetFont('Arial', '', 11);

            //Aplication NUMBER
            $pdf->SetXY(156, 17);
            $pdf->Write(1, "PV-0011");

            // Photo
            $pdf->Image(base_path('public/admin/student_photo/' . $student_data->photo), 164, 73.3, 33.5, 40.9);

            //Tick
            // $pdf->SetXY(48, 168.5);
            // $pdf->Write(1, $student_data->gender == 'Male' ? "V" : '');
            // $pdf->SetXY(68, 168.5);
            // $pdf->Write(1, $student_data->gender == 'Female' ? "V" : '');

            // Date
            $pdf->SetXY(59.5, 145.5);
            $pdf->Write(1, $student_data->created_at->format('d-m-Y'));

            //DOB
            $d = new DateTime($student_data->dob);
            $day = str_split($d->format('d'));
            $month = str_split($d->format('m'));
            $year = str_split($d->format('Y'));
            $pdf->SetXY(146, 168.5);
            $pdf->Write(1, $day[0]);
            $pdf->SetXY(155, 168.5);
            $pdf->Write(1, $day[1]);
            $pdf->SetXY(165, 168.5);
            $pdf->Write(1, $month[0]);
            $pdf->SetXY(173, 168.5);
            $pdf->Write(1, $month[1]);
            $pdf->SetXY(183, 168.5);
            $pdf->Write(1, $year[2]);
            $pdf->SetXY(190, 168.5);
            $pdf->Write(1, $year[3]);

            //Name
            $pdf->SetXY(48, 179.5);
            $pdf->Write(1, $student->name);

            //Father Name
            $pdf->SetXY(48, 189.5);
            $pdf->Write(1, $student_data->father_name);

            //Mother Name
            $pdf->SetXY(48, 199.5);
            $pdf->Write(1, $student_data->mother_name);

            // adhar
            $explode_id = str_split($student_data->adhar_number);
            $pdf->SetXY(49.5, 208.5);
            $pdf->Write(1, $explode_id['0']);
            $pdf->SetXY(57, 208.5);
            $pdf->Write(1, $explode_id['1']);
            $pdf->SetXY(65, 208.5);
            $pdf->Write(1, $explode_id['2']);
            $pdf->SetXY(70, 208.5);
            $pdf->Write(1, $explode_id['3']);
            $pdf->SetXY(77, 208.5);
            $pdf->Write(1, $explode_id['4']);
            $pdf->SetXY(85, 208.5);
            $pdf->Write(1, $explode_id['5']);
            $pdf->SetXY(92, 208.5);
            $pdf->Write(1, $explode_id['6']);
            $pdf->SetXY(99, 208.5);
            $pdf->Write(1, $explode_id['7']);
            $pdf->SetXY(107, 208.5);
            $pdf->Write(1, $explode_id['8']);
            $pdf->SetXY(112, 208.5);
            $pdf->Write(1, $explode_id['9']);
            $pdf->SetXY(120, 208.5);
            $pdf->Write(1, $explode_id['10']);
            $pdf->SetXY(126, 208.5);
            $pdf->Write(1, $explode_id['11']);

            // Gender
            if ($student_data->gender == 'Male') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 49, 166.5, 3, 3);
            } else {
                $pdf->Image(base_path('public/admin/images/checked.png'), 74, 166.5, 3, 3);
            }

            // category
            if ($student_data->category == 'General') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 100, 235, 3, 3);
            } else if ($student_data->category == 'SCS') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 49.5, 235, 3, 3);
            } else if ($student_data->category == 'ST') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 65.5, 235, 3, 3);
            } else if ($student_data->category == 'SC') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 82.5, 235, 3, 3);
            }


            if ($student_data->employment_status == 'Unemployed1') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 49.5, 225, 3, 3);
            } else if ($student_data->employment_status == 'Unemployed2') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 73, 225, 3, 3);
            } else if ($student_data->employment_status == 'Unemployed3') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 49, 225, 3, 3);
            } else if ($student_data->employment_status == 'Unemployed4') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 103, 225, 3, 3);
            } else if ($student_data->employment_status == 'Unemployed') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 127, 225, 3, 3);
            }

            // Country
            $pdf->SetXY(49, 248);
            $pdf->Write(1, $student_data->nationality);

            $pdf->SetXY(49, 258);
            $pdf->Write(1, $student_data->nationality);

            // Page 2
            $pageId = $pdf->importPage(2, PdfReader\PageBoundaries::MEDIA_BOX);
            $pdf->addPage();
            $pdf->useImportedPage($pageId, 0, 0, 210);

            // Address
            $pdf->SetXY(13, 30);
            $pdf->Write(1, $student_data->state);

            // State
            $pdf->SetXY(20, 39);
            $pdf->Write(1, $student_data->city);

            // State
            $pdf->SetXY(85, 39);
            $pdf->Write(1, $student_data->state);

            // Pincode
            $pdf->SetXY(155, 39);
            $pdf->Write(1, $student_data->pincode);

            // Payment mode
            // $pdf->Image(base_path('public/admin/images/checked.png'), 16, 237, 2, 2);

            // $pdf->SetXY(43, 237);
            // $pdf->Write(1, ($student->created_at)->format('d-m-Y'));

            // Signature
            $pdf->SetXY(46, 260);
            $pdf->Write(1, $student->name);

            // Signature
            $pdf->SetXY(145, 260);
            $pdf->Write(1, $student_data->father_name);

            // Place
            $pdf->SetXY(113, 269);
            $pdf->Write(1, ($student_data->state));

            $pdf->SetXY(23, 269);
            $pdf->Write(1, ($student->created_at)->format('d-m-Y'));
            // Page 3
            $pageId = $pdf->importPage(3, PdfReader\PageBoundaries::MEDIA_BOX);
            $pdf->addPage();
            $pdf->useImportedPage($pageId, 0, 0, 210);

            // Page 4
            $pageId = $pdf->importPage(4, PdfReader\PageBoundaries::MEDIA_BOX);
            $pdf->addPage();
            $pdf->useImportedPage($pageId, 0, 0, 210);

            $pdf->SetXY(23, 78);
            $pdf->Write(1, ($student->name));

            $pdf->SetXY(30, 158);
            $pdf->Write(1, ($student->created_at)->format('d-m-Y'));

            $pdf->SetXY(122, 158);
            $pdf->Write(1, ($student->name));

            $pdf->SetXY(117, 174);
            $pdf->Write(1, ($student->name));

            // Signature
            $pdf->SetXY(63, 207);
            $pdf->Write(1, $student_data->father_name);

            // Place
            $pdf->SetXY(30, 174);
            $pdf->Write(1, ($student_data->state));
        } else if ($university->uni_name == "SGVU") {
            $pdf->setSourceFile(base_path('public/admin/pdf/sgvu_student_form.pdf'));
            $pdf->addPage();
            $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
            $pdf->useImportedPage($pageId, 0, 0, 210);
            $pdf->SetFont('Arial', '', 11);

            $pdf->SetXY(101, 61.5);
            $pdf->Write(1, $student->course_name);

            //Centercode
            $pdf->SetXY(37, 70);
            $pdf->Write(1, $student->sub_course);

            $name = str_split($student->name);
            $x = 37;
            $y = 98;
            //Name
            for ($i = 0; $i < count($name); $i++) {
                $pdf->SetXY($x, $y);
                $pdf->Write(1, $name[$i]);
                $x = $x + 4;
            }

            //Father Name
            $f_name = str_split($student_data->father_name);
            $x = 37;
            $y = 106;
            for ($i = 0; $i < count($f_name); $i++) {
                $pdf->SetXY($x, $y);
                $pdf->Write(1, $f_name[$i]);
                $x = $x + 4;
            }

            //Mother Name
            $m_name = str_split($student_data->mother_name);
            $x = 37;
            $y = 114;
            for ($i = 0; $i < count($m_name); $i++) {
                $pdf->SetXY($x, $y);
                $pdf->Write(1, $m_name[$i]);
                $x = $x + 4;
            }

            // Gender
            if ($student_data->gender == 'Male') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 44, 121, 3, 3);
            } else {
                $pdf->Image(base_path('public/admin/images/checked.png'), 69, 121, 3, 3);
            }

            //DOB
            $d = new DateTime($student_data->dob);
            $day = str_split($d->format('d'));
            $month = str_split($d->format('m'));
            $year = str_split($d->format('Y'));
            $pdf->SetXY(121, 122);
            $pdf->Write(1, $day[0]);
            $pdf->SetXY(125, 122);
            $pdf->Write(1, $day[1]);
            $pdf->SetXY(132.5, 122);
            $pdf->Write(1, $month[0]);
            $pdf->SetXY(136.5, 122);
            $pdf->Write(1, $month[1]);
            $pdf->SetXY(145, 122);
            $pdf->Write(1, $year[0]);
            $pdf->SetXY(148, 122);
            $pdf->Write(1, $year[1]);
            $pdf->SetXY(152, 122);
            $pdf->Write(1, $year[2]);
            $pdf->SetXY(156, 122);
            $pdf->Write(1, $year[3]);

            // pincode
            $explode_id = str_split($student_data->pincode);
            $pdf->SetXY(67, 156.5);
            $pdf->Write(1, $explode_id['0']);
            $pdf->SetXY(71, 156.5);
            $pdf->Write(1, $explode_id['1']);
            $pdf->SetXY(75, 156.5);
            $pdf->Write(1, $explode_id['2']);
            $pdf->SetXY(79, 156.5);
            $pdf->Write(1, $explode_id['3']);
            $pdf->SetXY(83, 156.5);
            $pdf->Write(1, $explode_id['4']);
            $pdf->SetXY(87, 156.5);
            $pdf->Write(1, $explode_id['5']);

            // Address
            $pdf->SetXY(19, 162);
            $pdf->Write(1, $student->phone);
            $pdf->SetXY(61, 162);
            $pdf->Write(1, $student->phone);
            $pdf->SetXY(61, 162);
            $pdf->Write(1, $student->phone);

            //Mobile
            $pdf->SetXY(61, 172);
            $pdf->Write(1, $student->phone);

            // email
            $pdf->SetXY(24, 178);
            $pdf->Write(1, $student->email);

            // Country
            $pdf->Image(base_path('public/admin/images/checked.png'), 49, 194, 3, 3);

            // category
            if ($student_data->category == 'General') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 43.5, 202, 3, 3);
            } else if ($student_data->category == 'SC') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 56.5, 202, 3, 3);
            } else if ($student_data->category == 'ST') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 69.5, 202, 3, 3);
            } else if ($student_data->category == 'OBC') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 83.5, 202, 3, 3);
            }

            //Tick
            if ($student_data->employment_status == 'Unemployed1') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 148.5, 202, 3, 3);
            } else if ($student_data->employment_status == 'Employed') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 174.5, 202, 3, 3);
            } else if ($student_data->employment_status == 'Unemployed') {
                $pdf->Image(base_path('public/admin/images/checked.png'), 194.5, 202, 3, 3);
            }

            $pdf->Image(base_path('public/admin/student_photo/' . $student_data->photo), 167, 31.3, 30.5, 35.9);

            $pdf->Image(base_path('public/admin/student_signature/' . $student_data->signature), 167, 69.3, 30.5, 10.9);
        }

        $pdf->Output('D', $university->uni_name . $student->name . '-form.pdf');
        exit();
    }
}
