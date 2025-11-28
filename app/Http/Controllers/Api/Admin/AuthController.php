<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\LoginRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private const TOKEN_NAME = 'admin-mobile';

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();
            $user = User::with('role', 'roles')->where('email', $credentials['email'])->first();
        } catch (QueryException $e) {
            // Database connection error
            if (str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'refused')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Database connection failed. Please ensure MySQL is running in WAMP.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            throw $e;
        }

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Check if user has admin or manager role
        $userRole = $user->role?->slug ?? $user->roles->first()?->slug ?? 'staff';
        if (!in_array($userRole, ['admin', 'manager', 'super-admin'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied. Admin privileges required.',
            ], Response::HTTP_FORBIDDEN);
        }

        $tokenName = $credentials['device_name'] ?? self::TOKEN_NAME;

        // Prevent orphaned tokens for the same device name
        $user->tokens()->where('name', $tokenName)->delete();

        $token = $user->createToken($tokenName, ['admin'])->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
        ]);
    }

    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $currentToken = $user->currentAccessToken();
        $tokenName = $currentToken?->name ?? self::TOKEN_NAME;
        $currentToken?->delete();

        $token = $user->createToken($tokenName, ['admin'])->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    public function profile(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}

