<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostDeleteRequest;
use App\Http\Requests\PostIndexRequest;
use App\Http\Requests\PostPatchIsActiveRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
        private readonly UserRepositoryInterface $userRepository,
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(PostIndexRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $posts = $this->postRepository->get($attributes);
        return response()->json($posts, Response::HTTP_OK);
    }

    public function indexByLoggedUser(PostIndexRequest $request): JsonResponse
    {
        $user = $request->user();
        $attributes = $request->validated();
        $attributes['user_id'] = $user['id'];

        $posts = $this->postRepository->get($attributes);
        return response()->json($posts, Response::HTTP_OK);
    }

    public function indexByUserId(PostIndexRequest $request, int $userId): JsonResponse
    {
        $this->userRepository->findOrFail($userId);
        $attributes = $request->validated();
        $attributes['user_id'] = $userId;

        $posts = $this->postRepository->get($attributes);
        return response()->json($posts, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $attributes['is_active'] = true;
        $attributes['user_id'] = $request->user()->id;

        $post = $this->postRepository->store($attributes);
        return response()->json($post, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $postId): JsonResponse
    {
        $post = $this->postRepository->findOrFail($postId);
        return response()->json($post, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, int $postId): JsonResponse
    {
        $attributes = $request->validated();
        $post = $this->postRepository->update($postId, $attributes);
        return response()->json($post, Response::HTTP_OK);
    }

    public function updateIsActive(PostPatchIsActiveRequest $request, int $postId): JsonResponse
    {
        $attributes = $request->validated();
        $post = $this->postRepository->update($postId, $attributes);
        return response()->json($post, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostDeleteRequest $request, int $postId): Response
    {
        $this->postRepository->delete($postId);
        return response()->noContent();
    }
}
