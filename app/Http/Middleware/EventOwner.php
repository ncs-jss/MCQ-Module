<?php

namespace App\Http\Middleware;

use Closure;

class EventOwner
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
        $id = $request->route()->parameter('id');
        if(in_array($id, session('TeacherEvent')))
            return $next($request);
    }
}
