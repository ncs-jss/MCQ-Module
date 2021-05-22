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
        if ($role == 'student') {
            if (session('UserType') == 'teacher') {
                return redirect('/teacher');
            } elseif (session('UserType') == 'society') {
                return redirect('/society');
            }
        } elseif ($role == 'teacher') {
            if (session('UserType') == 'student') {
                return redirect('/student');
            } elseif (session('UserType') == 'society') {
                return redirect('/society');
            }
        } elseif ($role == 'society') {
            if (session('UserType') == 'student') {
                return redirect('/student');
            } elseif (session('UserType') == 'teacher') {
                return redirect('/teacher');
            }
        }
        return $next($request);
    }
}
