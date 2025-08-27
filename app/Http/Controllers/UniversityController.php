<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        $unis = University::all();
        return view('university', compact('unis'));
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name'=> 'required|string',
        ]);

        try {
            $University = new University;
            $University->name = $validated['name'];
            $University->save();
            return ['status'=>'200', 'msg'=>'University Created successfully!'];

        } catch (\Exception $e) {
            return response()->json(['status'=>$e, 'msg'=>$University]);
        }
    }

    public function edit($University)
    {
      $University = University::findOrFail($University);
      return view('form.university.edit',compact('University'));
    }


    public function update($University_id, Request $request)
    {
    $validated = $request->validate([
        'name'=> 'required|string',
  ]);

      try {
        $University = University::findOrFail($University_id);
        $University->name = $validated['name'];
        $University->save();
      return ['status'=>'200', 'msg'=>'University Updated successfully!'];

      } catch (\Exception $e) {
          return response()->json(['status'=>$e, 'msg'=>$University]);
      }
}
public function destroy($id){
    $University = University::find($id);
    $University->delete($id);
    return ['status'=>'200', 'msg'=>'content deleted successfully!'];
  }
}
