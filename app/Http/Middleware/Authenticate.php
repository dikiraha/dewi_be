<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $isApi = $request->expectsJson() || $request->is('api/*');

            if ($isApi) {
                if (!auth('api')->check()) {
                    return response()->json(['message' => 'Unauthenticated.'], 401);
                }
            } else {
                if (!auth()->check()) {
                    return redirect()->route('website.showLoginForm');
                }
            }

            return $next($request);
        } catch (\Exception $e) {
            return $isApi
                ? response()->json(['message' => 'Token error: ' . $e->getMessage()], 401)
                : redirect()->route('website.showLoginForm')->with('error', 'Token error.');
        }
    }
}
