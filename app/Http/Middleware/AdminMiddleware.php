<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check 1: If the user is not authenticated, redirect to the login page.
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check 2: If the user is authenticated but not an admin (is_admin is false).
        if (Auth::check() && !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Authorization Required: You do not have the necessary administrative privileges to access this resource.');
        }

        // Check 3: If the user is authenticated and is an admin, allow the request to proceed.
        return $next($request);
    }
}
