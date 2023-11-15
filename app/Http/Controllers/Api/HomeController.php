<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PostRepositoryInterface $postRepository,
        private readonly CommentRepositoryInterface $commentRepository,
    )
    {

    }

    public function dashboards(): JsonResponse
    {
        $data = [];
        $data['total_users'] = $this->userRepository->countUsers();
        $data['total_posts'] = $this->postRepository->countPosts();
        $data['total_comments'] = $this->commentRepository->countComments();
        $data['most_commented_posts'] = $this->postRepository->getMostCommentedPosts();
        $data['users_with_most_posts'] = $this->userRepository->getUsersWithMostPosts();
        $data['users_with_most_comments'] = $this->userRepository->getUsersWithMostComments();

        return response()->json($data, Response::HTTP_OK);
    }
}
