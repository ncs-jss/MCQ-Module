<?php

namespace App\Http\Middleware;

use Closure;
use App\Req;
use App\Event;
use App\Queans;
use App\Option;
use Auth;

class EventPlay
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()->has('event'))
        {
            return redirect(custom_url('student/event/play/1'));
        }
        else
        {
            if(!session()->has('eventcheck'))
            {
                $reqs = Req::select('eventid','status','que','start')->where('status',1)->where('userid',Auth::id())->whereNotNull('que')->get()->toArray();
                $events = Event::select('id','start','end','isactive','quedisplay','duration')->whereIn('id',array_column($reqs,'eventid'))->get()->toArray();
                $data = [];
                foreach($reqs as $req)
                {
                    $key = array_search($req['eventid'],array_column($events,'id'));
                    if($events[$key]['isactive'] == 1 && $events[$key]['start'] <= date('Y-m-d H:i:s') && $events[$key]['end'] >= date('Y-m-d H:i:s'))
                    {
                        if(strtotime($req['start']." + ".$events[$key]['duration']." minute") > strtotime(date('Y-m-d H:i:s')))
                        {
                            $queid = explode(',', $req['que']);
                            $que = Queans::select('id','que','quetype')->whereIn('id',$queid)->get()->toArray();

                            $options = Option::select('id','ans','queid')->whereIn('queid',array_column($que,'id'))->get()->toArray();

                            $submit = [];
                            for($i=0; $i<count($que); $i++)
                                $submit[$i] = 0;

                            $response = [];
                            for($i=0; $i<count($que); $i++)
                                $response[$i] = "";

                            session(
                                [
                                    'event' => $events[$key],
                                    'que' => $que,
                                    'submit' => $submit,
                                    'duration' => $events[$key]['duration'],
                                    'start' => $req['start'],
                                    'options' => $options,
                                    'response' => $response,
                                ]
                            );
                            session(['eventcheck' => 1]);
                            return redirect('student/event/play/1');
                        }
                    }
                    else   
                    {  
                        array_push($data,$events[$key]['id']); 
                    }  
                }  
                if(count($data) > 0)   
                {  
                    Req::where('userid',Auth::id())->whereIn('eventid',$data)->delete();
                }
                session(['eventcheck' => 1]);
            }
            return $next($request);
        }
    }
}
