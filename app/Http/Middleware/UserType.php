<?php

namespace App\Http\Middleware;

use Closure;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if($role == 'student') {
            if(session('UserType') == 'teacher') {
                return redirect('/teacher');
            } else if(session('UserType') == 'society') {
                return redirect('/society');
            }
        }
        else if($role == 'teacher') {
            if(session('UserType') == 'student') {
                return redirect('/student');
            } else if(session('UserType') == 'society') {
                return redirect('/society');
            }
        }
        else if($role == 'society') {
            if(session('UserType') == 'student') {
                return redirect('/student');
            } else if(session('UserType') == 'teacher') {
                return redirect('/teacher');
            }
        }
        return $next($request);
    }
}
