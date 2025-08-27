<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Acadmics;

class AcadmicsController extends Controller
{
    public function storeAcadmics(Request $request){
        $validated = $request->validate([
            'student_id'=> 'required|string',
            'father_name'=> 'required|string',
            'mother_name'=> 'required|string',
            'gender'=> 'required|string',
            'category'=> 'required|string',
            'emp_tatus'=> 'required|string',
            'adhar_number'=> 'required|string',
            'nationality'=> 'required|string',
            'pincode'=> 'required|integer',
            'city'=> 'required|string',
            'district'=> 'required|string',
            'state'=> 'required|string',
        ]);
        $acadmics_check = Acadmics::where('id', $request->ledger_id)->first();

        if($acadmics_check){
            $acadmics = Acadmics::findOrFail($acadmics_check->id);
                $acadmics->student_id = $validated['student_id'];
                $acadmics->center_code = 3031;
                $acadmics->father_name = $validated['father_name'];
                $acadmics->mother_name = $validated['mother_name'];
                $acadmics->adhar_number = $validated['adhar_number'];
                $acadmics->nationality = $validated['nationality'];
                $acadmics->pincode = $validated['pincode'];
                $acadmics->category = $validated['category'];
                $acadmics->employment_status = $validated['emp_tatus'];
                $acadmics->gender = $validated['gender'];
                $acadmics->city = $validated['city'];
                $acadmics->distric = $validated['district'];
                $acadmics->state = $validated['state'];
                $acadmics->created_at = now();
                $acadmics->updated_at = now();
                $acadmics_saved = $acadmics->save();
    
                if($acadmics_saved){
                    return ['status'=>'200', 'msg'=>'Student acadmics updated successfully!'];
                }
        }else{
            try {
                $photo = '';
                if($request->file('photo')){
                    $photo = time(). '.' .$request->file('photo')->getClientOriginalExtension();
                    $request->photo->move(public_path('admin/student_photo'), $photo);
                }
    
                $signature = '';
                if($request->file('signature')){
                    $signature = time().'.'.$request->file('signature')->getClientOriginalExtension();
                    $request->signature->move(public_path('admin/student_signature'), $signature);
                }
               
                $acadmics = new Acadmics;
                $acadmics->student_id = $validated['student_id'];
                $acadmics->center_code = 3031;
                $acadmics->father_name = $validated['father_name'];
                $acadmics->mother_name = $validated['mother_name'];
                $acadmics->adhar_number = $validated['adhar_number'];
                $acadmics->nationality = $validated['nationality'];
                $acadmics->pincode = $validated['pincode'];
                $acadmics->category = $validated['category'];
                $acadmics->employment_status = $validated['emp_tatus'];
                $acadmics->gender = $validated['gender'];
                $acadmics->city = $validated['city'];
                $acadmics->distric = $validated['district'];
                $acadmics->state = $validated['state'];
                $acadmics->signature = $photo;
                $acadmics->photo = $signature;
                $acadmics->created_at = now();
                $acadmics->updated_at = now();
                $acadmics_saved = $acadmics->save();
    
                if($acadmics_saved){
                    return ['status'=>'200', 'msg'=>'Student acadmics details ddded successfully!'];
                }
            } catch (\Exception $e) {
                return response()->json(['status'=>$e, 'msg'=>$acadmics]);
            }
        }

        
    }

    public function addAdcadmics($student_id=null){
        $student = Student::where('id', $student_id)->first();
        $acadmics = Acadmics::where('student_id', $student_id)->first();
        return view('form.student.ajax.add-student-acadmics',compact('student', 'acadmics'));
    }
}
