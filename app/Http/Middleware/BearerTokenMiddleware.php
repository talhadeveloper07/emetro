<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BearerTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expectedToken = env('PORTAL_API_KEY');
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader || $authorizationHeader !== $expectedToken) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'Invalid or missing Bearer token.',
            ], 401);
        }
        return $next($request);
    }
}
