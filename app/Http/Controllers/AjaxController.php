<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Req;
use Auth;

class AjaxController extends Controller
{
    public function event_req(Request $request)
    {
    	$req = Req::select('status')->where('userid', Auth::id())->where('eventid', $request->id)->first();
    	return json_encode(array('status'=> $req->status));
    }
}
