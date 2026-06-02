<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is logged in and has the required role
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized. This area is reserved for ' . ucfirst($role) . ' accounts.');
        }

        return $next($request);
    }
}