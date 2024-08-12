<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckActiveStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->isActive()) {
            Auth::logout();  // This logs out the user using the default guard

            // Redirect to the login page with an error message
            return redirect('login')->with('error', 'Your account has been suspended. Please contact support.');
        }
        return $next($request);
    }
}
