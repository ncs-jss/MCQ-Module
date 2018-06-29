<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Req;
use Auth;

class ReqController extends Controller
{
    public function join(Request $request)
    {
    	$event = Event::select('start','end','isactive')->where('id',$request->input('id'))->first();
    	if(!empty($event))
    	{
    		if($event->isactive == 1 && $event->start <= date('Y-m-d H:i:s') && $event->end >= date('Y-m-d H:i:s'))
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
    	}
    }
}
