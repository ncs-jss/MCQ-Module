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
                    $event = Event::select('quedisplay','duration')->where('id', $request->input('id'))->first();

                    $que = Queans::select('id','que','quetype')->where('eventid',$request->input('id'))->take($event->quedisplay)->get()->toArray();
                    shuffle($que);

                    $req = Req::where('userid', Auth::id())->where('eventid', $request->input('id'))->update(
                        [
                            'start' => date("Y-m-d H:i:s"),
                            'que' => implode(",",array_column($que,'id'))
                        ]
                    );

                    $options = Option::select('id','ans','queid')->whereIn('queid',array_column($que,'id'))->get()->toArray();

                    $submit = [];
                    for($i=0; $i<count($que); $i++)
                        $submit[$i] = 0;

                    session(
                        [
                            'event' => $request->input('id'),
                            'que' => $que,
                            'submit' => $submit,
                            'duration' => $event->duration,
                            'start' => date("Y-m-d H:i:s"),
                            'options' => $options,
                        ]
                    );

                    // dd(session()->all());

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
                    return view('student.play',['queid' => $queid, 'eventid' => $id]);
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
