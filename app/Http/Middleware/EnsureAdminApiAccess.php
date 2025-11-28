<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminApiAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !in_array($user->role ?? 'staff', ['admin', 'manager'])) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Unauthorized: admin access required.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}

