<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('course', compact('courses'));
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name'=> 'required|string',
        ]);

        try {
            $course = new Course;
            $course->name = $validated['name'];
            $course->save();
            return ['status'=>'200', 'msg'=>'course Created successfully!'];

        } catch (\Exception $e) {
            return response()->json(['status'=>$e, 'msg'=>$course]);
        }
    }

    public function edit($course)
    {
      $course = Course::findOrFail($course);
      return view('form.course.edit',compact('course'));
    }


    public function update($course_id, Request $request)
    {
    $validated = $request->validate([
        'name'=> 'required|string',
  ]);

      try {
        $course = Course::findOrFail($course_id);
        $course->name = $validated['name'];
        $course->save();
      return ['status'=>'200', 'msg'=>'course Updated successfully!'];

      } catch (\Exception $e) {
          return response()->json(['status'=>$e, 'msg'=>$course]);
      }
}
public function destroy($id){
    $course = Course::find($id);
    $course->delete($id);
    return ['status'=>'200', 'msg'=>'content deleted successfully!'];
  }
}
