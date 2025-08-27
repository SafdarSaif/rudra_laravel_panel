<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function userLogin(Request $request){
        request()->validate([
            'email' => 'required',
            'password' => 'required',

        ]);

        if (Auth::guard('webadmin')->attempt($request->only('email', 'password'))) {
            if(Auth::guard('webadmin')->user()->status == 1){
                return redirect()->route('dashboard')->with('success', 'Login successfully');
            }else{
                return redirect()->route('login')->with('error', 'Your are not active!!');
            }
            
        } else {
            return redirect()->route('login')->with('error', 'Your email or password does not matched');
        }
    }
}
