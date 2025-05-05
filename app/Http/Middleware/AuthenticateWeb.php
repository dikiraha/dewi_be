<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!auth()->check()) {
                return redirect()->route('website.showLoginForm');
            }

            return $next($request);
        } catch (\Exception $e) {
            return redirect()->route('website.showLoginForm')
                ->with('error', 'Authentication error: ' . $e->getMessage());
        }
    }
}
