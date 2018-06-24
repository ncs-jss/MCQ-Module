<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class InfoConnectApiController extends Controller
{
    public function login(Request $request)
    {
    	$this->validate($request, [
        	'username' => 'required',
        	'password' => 'required',
    	]);

    	$postData = array(
        	'username' => $request->input('username'),
        	'password' => $request->input('password')
	    );
	    
	    //API URL
	    $url=config('infoConnectApi.url');
	    
	    // init the resource
	    $ch = curl_init();
	    curl_setopt_array($ch, array(
	        CURLOPT_URL => $url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_POST => true,
	        CURLOPT_POSTFIELDS => $postData
	    ));
	    

	    //Ignore SSL certificate verification
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	    //get response
	    $output = curl_exec($ch);
	    
	    //Print error if any
	    if(curl_errno($ch))
	    {
	        echo 'error:' . curl_error($ch);
	    }
	    
	    curl_close($ch);
	    
	    $arr = json_decode($output, true);

	    if (array_key_exists('username',$arr))
	    {

	    	$user = User::select('id')->where('admno', '=', $arr['username'])->first();
	    	if (empty($user))
	    	{
	    		$user = new User;
	    		$user->name = $arr['first_name'];
	    		$user->admno = $arr['username'];
	    		if($arr['group']=="student")
	    			$user->type = 0; // Student
	    		else if($arr['group']=="others")
	    			$user->type = 1; // Society
	    		else
	    			$user->type = 2; // Teacher
	    		$user->save();
	    	}

	    	Auth::loginUsingId($user->id);
	    	if($arr['group']=="student")
	    	{
	    		session(['UserType' => 'student']);
	    		return redirect('student');
	    	}
	    	else if($arr['group']=="others")
	    	{
	    		session(['UserType' => 'society']);
	    		return redirect('society');
	    	}
	    	else
	    	{
	    		session(['UserType' => 'teacher']);
	    		return redirect('teacher');
	    	}
	    }
	    else
	    {
	    	return back()->with('msg','The username and/or password you specified are not correct.');
	    }
    }

    public function logout()
    {
    	Auth::logout();
    	return redirect()->route('login');
    }
}
