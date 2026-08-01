<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth as Auth;

class HodMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if user is hod and also check if the hod is active
        // if active -> allow to login 
        // // if not -> 403 unauthorized

        // if (Auth::user()->role === 'hod' && Auth::user()->hod->status === 'active') {
        //     return $next($request);
        // } else if (Auth::user()->role === 'hod' && Auth::user()->hod->status !== 'active') {
        //     Auth::logout();
        //     abort(403, 'Your HoD account has been terminated.');
        // }

        $user = Auth::user();

        if ($user->role === 'hod') {
            if ($user->hod && $user->hod->status === 'active') {
                return $next($request);
            } elseif ($user->hod && $user->hod->status !== 'active') {
                Auth::logout();
                abort(403, 'Your HoD account has been terminated.');
            } else {
                Auth::logout();
                abort(403, 'Log Out');
            }
        }
        abort(403, 'Unauthorized');
    }
}
