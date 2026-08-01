<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth as Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        // if (Auth::user()->role === 'admin') {
        //     return $next($request);
        // } else {
        //     return redirect()->route('user.dashboard');
        // }

        if (Auth::user()->role === 'admin') {
            return $next($request);
        }
        abort(403, 'Unauthorized');
        /// is a Laravel helper function that immediately stops the request and returns an HTTP error response.

        //403 → HTTP status code, 403 = Forbidden
        ///'Unauthorized' → Custom error message
        // means: You are not allowed to access this page.
    }
}
