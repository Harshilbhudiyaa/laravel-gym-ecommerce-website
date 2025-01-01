<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('user')) {
            // Redirect to login page if session variable is not set
            return redirect()->route('login');
        }
        return $next($request);
    }
}
