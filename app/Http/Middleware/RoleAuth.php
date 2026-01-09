<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // If no specific roles provided, check if authenticated as any role
        if (empty($roles)) {
            if (Auth::guard('student')->check()) {
                Auth::shouldUse('student');
                return $next($request);
            }

            if (Auth::guard('lecturer')->check()) {
                Auth::shouldUse('lecturer');
                return $next($request);
            }

            return redirect('/login')->with('error', 'Please log in first');
        }

        // Check each specified role
        foreach ($roles as $role) {
            if (Auth::guard($role)->check()) {
                Auth::shouldUse($role);
                return $next($request);
            }
        }

        return redirect('/login')->with('error', 'Please log in first');
    }
}
