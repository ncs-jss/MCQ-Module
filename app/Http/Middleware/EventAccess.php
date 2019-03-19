<?php

namespace App\Http\Middleware;

use Closure;
use \App\Event;

class EventAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $event = Event::select('start', 'end', 'isactive')->where('id', $request->id)->first();
        if (!empty($event)) {
            if ($event->isactive == 1 && $event->start <= date('Y-m-d H:i:s') && $event->end >= date('Y-m-d H:i:s')) {
                return $next($request);
            } else {
                return back()
                    ->with(['msg' => 'The event you are trying to access is invalid', 'class' => 'alert-danger']);
            }
        }
    }
}
