<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserIndexRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserUploadProfilePictureRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {

    }

    public function index(UserIndexRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $users = $this->userRepository->get($attributes);
        return response()->json($users, Response::HTTP_OK);
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $user = $this->userRepository->store($attributes);

        $token = $user->createToken('token');

        $user['token'] = [
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ];

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $user = $request->user();
        $user = $this->userRepository->update($user['id'], $attributes);
        return response()->json($user, Response::HTTP_OK);
    }

    public function updatePassword(UserUpdatePasswordRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $currentPassword = $attributes['current_password'];

        $user = $request->user();
        $password = $user['password'];

        if(Hash::check($currentPassword, $password)) {
            $attributes = ['password' => $attributes['new_password']];
            $user = $this->userRepository->update($user['id'], $attributes);
            return response()->json($user, Response::HTTP_OK);
        }

        return response()->json([
            'error' => 'Incorrect password.'
        ]);
    }

    public function showByLoggedUser(Request $request): JsonResponse
    {
        $user = $request->user();
        $user = $this->userRepository->findOrFail($user['id']);
        return response()->json($user, Response::HTTP_OK);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->findOrFail($id);
        return response()->json($user, Response::HTTP_OK);
    }

    public function destroy(int $id): Response
    {
        $this->userRepository->delete($id);
        return response()->noContent();
    }

    public function destroyByLoggedUser(Request $request): Response
    {
        $user = $request->user();
        $this->userRepository->delete($user['id']);
        return response()->noContent();
    }

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

    public function uploadProfilePicture(UserUploadProfilePictureRequest $request): JsonResponse
    {
        $user = $request->user();

        if(!is_null($user['profile_picture'])) {
            Storage::delete($user['profile_picture']);
        }

        $file = $request->file('profile_picture');
        $url = Storage::put(User::PATH_PROFILE_PICTURES, $file);

        $attributes = [
            'profile_picture' => $url,
        ];

        $user = $this->userRepository->update($user['id'], $attributes);
        return response()->json(['profile_picture' => $user['profile_picture']], Response::HTTP_OK);
    }
}
