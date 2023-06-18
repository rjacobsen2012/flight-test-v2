<?php

namespace App\Http\Controllers;

use App\Http\Auth\AuthHandler;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Http\Message\StreamInterface;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    use AuthHandler;

    public function signup(AuthRequest $request): string
    {
        if (!$this->createUser($request)) {
            return response()->json([
                'message' => 'User already exists',
            ]);
        }

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function login(AuthRequest $request): StreamInterface|JsonResponse
    {
        return $this->handleLogin($request);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
