<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!auth('api')->check()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token error: ' . $e->getMessage()], 401);
        }
    }
}
