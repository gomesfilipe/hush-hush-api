<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentDeleteRequest;
use App\Http\Requests\CommentIndexRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function __construct(
        private readonly CommentRepositoryInterface $commentRepository,
        private readonly PostRepositoryInterface $postRepository
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function indexByPostId(CommentIndexRequest $request, int $postId): JsonResponse
    {
        $attributes = $request->validated();
        $this->postRepository->findOrFail($postId);
        $comments = $this->commentRepository->getByPostId($postId, $attributes);
        return response()->json($comments, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentStoreRequest $request, int $postId): JsonResponse
    {
        $user = $request->user();

        $attributes = $request->validated();
        $attributes['post_id'] = $postId;
        $attributes['user'] = $user['id'];

        $comment = $this->commentRepository->store($attributes);
        return response()->json($comment, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, int $commentId): JsonResponse
    {
        $attributes = $request->validated();
        $comment = $this->commentRepository->update($commentId, $attributes);
        return response()->json($comment, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommentDeleteRequest $request, int $commentId): Response
    {
        $this->commentRepository->delete($commentId);
        return response()->noContent();
    }
}
