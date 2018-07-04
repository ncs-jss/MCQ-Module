<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Req;
use App\Queans;
use App\Option;
use App\Response;
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
                if(!session()->has('event') || 1==1)
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

                    /* ##########################
                    0 = Not visited, nor answered
                    1 = Visited
                    2 = Answered
                    ############################# */
                    $submit = [];
                    for($i=0; $i<count($que); $i++)
                        $submit[$i] = 0;

                    $response = [];
                    for($i=0; $i<count($que); $i++)
                        $response[$i] = "";

                    session(
                        [
                            'event' => $event->toArray(),
                            'que' => $que,
                            'submit' => $submit,
                            'duration' => $event->duration,
                            'start' => date("Y-m-d H:i:s"),
                            'options' => $options,
                            'response' => $response,
                        ]
                    );

                    // dd(session()->all());

                    return redirect(url('student/event/play/1'));
                }
            }
        }
    }

    public function play($queid)
    {
        if(session()->has('event'))
        {
            if($queid <= count(session('que')))
            {
                return view('student.play',['queid' => $queid]);
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

    public function response(Request $request, $queid)
    {

        /* ##########################
        0 = Not visited, nor answered
        1 = Visited
        2 = Answered
        ############################# */
        if(empty($request->input('opt')) && session('submit')[$request->input('curid')-1] == 0)
        {
            $submit = session('submit');
            $submit[$request->input('curid')-1] = 1;
            session(['submit' => $submit]);
        }
        if(!empty($request->input('opt')))
        {
            $submit = session('submit');
            $submit[$request->input('curid')-1] = 2;
            session(['submit' => $submit]);

            $response = session('response');
            $response[$request->input('curid')-1] = implode(",",$request->input('opt'));
            session(['response' => $response]);
        }

        return $this->play($queid);
    }

    public function submit(Request $request)
    {
        if(!empty($request->input('opt')))
        {
            $submit = session('submit');
            $submit[$request->input('curid')-1] = 2;
            session(['submit' => $submit]);

            $response = session('response');
            $response[$request->input('curid')-1] = implode(",",$request->input('opt'));
            session(['response' => $response]);
        }


        $data = [];
        $userid = Auth::id();
        $submit = session('submit');
        $que = session('que');
        $response = session('response');
        for($i=0; $i<count(session('submit')); $i++)
        {
            if($submit[$i] == 2)
            {
                $value = [];
                $value['userid'] =  $userid;
                $value['queid'] =  $que[$i]['id'];
                $value['ans'] =  $response[$i];
                array_push($data,$value);
                unset($value);
            }
        }
        Response::insert($data);

        return 1;
    }
}
