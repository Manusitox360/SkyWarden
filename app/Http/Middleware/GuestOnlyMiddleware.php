<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
class GuestOnlyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is a guest (not authenticated)
        if (Auth::guest()) {
            // Allow only GET requests for guests
            if ($request->isMethod('get')) {
                return $next($request);
            }

            // Deny other request methods for guests
            return response()->json(['message' => 'Unauthorized - Guests can only perform GET requests'], 403);
        }

        // If the user is authenticated, allow the request
        return $next($request);
    }
}
