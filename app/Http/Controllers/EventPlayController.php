<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Req;
use App\Queans;
use App\Option;
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
                    $req = Req::where('userid', Auth::id())->where('eventid', $request->input('id'))->update(['start' => date("Y-m-d H:i:s")]);

                    $event = Event::select('quedisplay')->where('id', $request->input('id'))->first();

                    $que = Queans::where('eventid',$request->input('id'))->take($event->quedisplay)->pluck('id')->toArray();
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

    public function play(Request $request, $id, $queid)
    {
        if(session()->has('event'))
        {
            if(session()->has('event') == $id)
            {
                if($queid <= count(session('que')))
                {
                    $queNo = session('que')[$queid-1];
                    $que = Queans::where('id',$queNo)->first();
                    $option = Option::where('queid',$queNo)->get();
                    $duration = Event::where('id', $id)->pluck('duration')->toArray();
                    $start = Req::where('userid', Auth::id())->where('eventid', $id)->pluck('start')->toArray();
                    $end = strtotime($start[0]." + ".$duration[0]." minute");
                    $end = date('Y-m-d H:i:s', $end);
                    return view('student.play',['queid' => $queid, 'que' => $que, 'options' => $option, 'eventid' => $id, 'end' => $end]);
                }
                else
                {
                    return back();
                }
            }
            else
            {
                return back();
            }
        }
        else
        {
            return back();
        }
    }
}
