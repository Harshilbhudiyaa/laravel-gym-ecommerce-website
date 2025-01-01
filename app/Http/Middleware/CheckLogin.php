<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('user_id')) {
            // Redirect to the login page if user is not logged in
            return redirect('/login')->with('error', 'Please log in to access the checkout page.');
        }

        // Proceed to the next request if user is logged in
        return $next($request);
    }
}
