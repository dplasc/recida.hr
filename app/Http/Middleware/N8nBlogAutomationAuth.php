<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class N8nBlogAutomationAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = config('services.n8n_blog.secret');
        if (!is_string($expected) || $expected === '') {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
            ], 401);
        }

        $token = $request->bearerToken();
        if (!is_string($token) || $token === '') {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
            ], 401);
        }

        if (!hash_equals($expected, $token)) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
