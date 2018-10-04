<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
    	$validation = [
    		'name' => 'required|max:100',
    		'email' => 'sometimes|nullable|email|max:100'
    	];
        $adm_yr = substr(Auth::user()->admno, 0, 5);
        $cur_yr = date("Y") - 2000;
        if($cur_yr > $adm_yr)
        {
        	$validation['rollno'] = 'required|numeric|max:9999999999|min:1000000000';
        }
        else
        {
        	$validation['rollno'] = 'sometimes|nullable|numeric|max:11|min:11';
        }
        $this -> validate($request,$validation);

        $user = User::where('id', Auth::User()->id)->update([
        	'name' => $request->input('name'),
        	'email' => $request->input('email'),
        	'rollno' => $request->input('rollno')
        ]);

        if($request->input('newuser') == 0)
        	return back()->with(['msg' => 'You profile has been successfully updated.', 'class' => 'alert-success']);
        else
        	return redirect('student')->with(['msg' => 'You profile has been successfully updated.', 'class' => 'alert-success']);
    }
}
