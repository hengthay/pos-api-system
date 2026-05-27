<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Get user
        $user = $request->user();

        // Log::debug('user info', ['user' => $user]);

        if(!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Trim role
        $roles = array_map('trim', $roles);
        
        // Check if current role is allowed, if not block access
        if(!in_array($user->role, $roles, true)) {
            return response()->json(['message' => 'Forbidden to access.'], 403);
        }
        
        // Doing next step
        return $next($request);
    }
}
