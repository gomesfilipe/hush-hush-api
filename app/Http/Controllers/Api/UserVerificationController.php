<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserVerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request, int $userId, string $hash): JsonResponse|Response
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['error' => 'Email has been verified already.'], Response::HTTP_UNAUTHORIZED);
        }

        $user->markEmailAsVerified();
        return response()->noContent();
    }

    public function resend(Request $request): JsonResponse|Response
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['error' => 'Email has been verified already.'], Response::HTTP_UNAUTHORIZED);
        }

        $user->sendEmailVerificationNotification();

        return response()->noContent();
    }
}
