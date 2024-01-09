<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if(Auth::attempt($credentials) === false) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();
        $token = $user->createToken('token');

        $user['token'] = [
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ];

        return response()->json($user, Response::HTTP_OK);
    }

    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
