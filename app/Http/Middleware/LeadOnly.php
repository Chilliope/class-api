<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeadOnly
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        $user = $request->user();

        if (!$user || $user->role !== 'lead') {
            return response()->json([
                'message' => 'Access denied. Only team leads can access this resource.'
            ], 403);
        }

        return $next($request);
    }
}
