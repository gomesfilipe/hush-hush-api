<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements Interfaces\PostRepositoryInterface
{
    public function store(array $attributes): object
    {
        return Post::query()
            ->create($attributes);
    }

    public function get(array $params = []): LengthAwarePaginator
    {
        $count = $params['count'] ?? 50;
        $title = $params['title'] ?? null;
        $startDate = $params['start_date'] ?? null;
        $endDate = $params['end_date'] ?? null;
        $userId = $params['user_id'] ?? null;
        $orderBy = $params['order_by'] ?? 'created_at DESC';

        $query = Post::query();

        if(!is_null($title)) $query->where('title', 'LIKE', "%$title%");
        if(!is_null($startDate)) $query->where('created_at', '>=', $startDate);
        if(!is_null($endDate)) $query->where('end_at', '<=', $endDate);
        if(!is_null($userId)) $query->where('user_id', '=', $userId);

        return $query
            ->with('user')
            ->withCount('comments')
            ->orderByRaw($orderBy)
            ->paginate($count);
    }

    public function findOrFail(int $postId): object
    {
        return Post::query()
            ->with('user')
            ->withCount('comments')
            ->findOrFail($postId);
    }

    public function update(int $postId, array $attributes): object
    {
        $post = Post::query()
            ->findOrFail($postId);

        $post->fill($attributes)->save();
        return $post;
    }

    public function delete(int $postId): bool|null
    {
        return Post::query()
            ->findOrFail($postId)
            ->delete();
    }

    public function countPostsByUserId(int $userId): int
    {
        return Post::query()
            ->where('user_id', '=', $userId)
            ->count();
    }

    public function getMostCommentedPosts(int $count = 3): array
    {
        return $this->get([
            'count' => $count,
            'order_by' => 'comments_count DESC',
        ])->toArray()['data'];
    }

    public function countPosts(): int
    {
        return Post::query()
            ->count();
    }

    public function isActivePost(int $postId): bool
    {
        return Post::query()
            ->select(['is_active'])
            ->findOrFail($postId)['is_active'];
    }

    public function postBelongsToUser(int $postId, int $userId): bool
    {
        $post = Post::query()
            ->findOrFail($postId);

        return $post['user_id'] === $userId;
    }
}
