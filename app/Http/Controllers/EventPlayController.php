<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Req;
use App\Queans;
use Auth;

class EventPlayController extends Controller
{
    public function req(Request $request)
    {
        $req = Req::select('status')->where('userid', Auth::id())->where('eventid', $request->input('id'))->first();
        if(empty($req))
        {
    		$req = new Req;
    		$req->userid = Auth::id();
    		$req->eventid = $request->input('id');
    		$req->status = '0';
    		$req->save();
    		return back()->with('msg','You had successfully requested to join this event.');
    	}
    }

    public function join(Request $request)
    {
        $req = Req::select('status')->where('userid', Auth::id())->where('eventid', $request->input('id'))->first();
        if(!empty($req))
        {
            if($req->status == 1)
            {
                if(!session()->has('event'))
                {
                    $req = new Req;
                    $req->start = date("Y-m-d H:i:s");
                    $req->where('userid', Auth::id())->where('eventid', $request->input('id'))->first()->save();

                    $que = Queans::where('eventid',$request->input('id'))->pluck('id')->toArray();
                    shuffle($que);

                    $submit = [];
                    for($i=0; $i<count($que); $i++)
                        $submit[$i] = 0;

                    session(['event' => $request->input('id'), 'que' => $que, 'submit' => $submit]);

                    return redirect(url('student/event/'.$request->input('id').'/play/1'));
                }
            }
        }
    }
}
