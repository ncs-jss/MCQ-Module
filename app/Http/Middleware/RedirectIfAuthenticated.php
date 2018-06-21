<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check())
        {
            if(session('UserType') == 'student')
                return redirect('/student');
            else if(session('UserType') == 'teacher')
                return redirect('/teacher');
            else if(session('UserType') == 'society')
                return redirect('/society');
        }

        return $next($request);
    }
}
