<?php

namespace App\Repositories;

use App\Enums\EvaluationStatusEnum;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CommentRepository implements CommentRepositoryInterface
{
    public function store(array $attributes): object
    {
        return Comment::query()
            ->create($attributes);
    }

    public function get(array $params = []): LengthAwarePaginator
    {
        $count = $params['count'] ?? 50;
        $orderBy = $params['order_by'] ?? 'created_at DESC';

        return Comment::query()
            ->withCount([
                'evaluations as likes_count' => function ($query) {
                    $query->where('status', EvaluationStatusEnum::LIKE);
                },

                'evaluations as dislikes_count' => function ($query) {
                    $query->where('status', EvaluationStatusEnum::DISLIKE);
                },
            ])
            ->orderByRaw($orderBy)
            ->paginate($count);
    }

    public function getByPostId(int $postId, array $params = []): LengthAwarePaginator
    {
        $count = $params['count'] ?? 50;
        $orderBy = $params['order_by'] ?? 'created_at DESC';
        $userId = $params['user_id'] ?? null;

        $queryBuilder = Comment::query();

        if (! is_null($userId)) {
            $queryBuilder
                ->leftJoin('evaluations', function (JoinClause $join) use ($userId) {
                    $join->on('comments.id', '=', 'evaluations.comment_id')
                        ->where('evaluations.user_id', '=', $userId);
                });
        }

        return $queryBuilder
            ->select('comments.*', DB::raw("COALESCE(evaluations.status, 'None') as user_evaluation"))
            ->where('post_id', '=', $postId)
            ->with('user')
            ->withCount([
                'evaluations as likes_count' => function ($query) {
                    $query->where('status', EvaluationStatusEnum::LIKE);
                },

                'evaluations as dislikes_count' => function ($query) {
                    $query->where('status', EvaluationStatusEnum::DISLIKE);
                },
            ])
            ->orderByRaw($orderBy)
            ->paginate($count);
    }

    public function update(int $commentId, array $attributes): object
    {
        $comment = Comment::query()
            ->findOrFail($commentId);

        $comment->fill($attributes)->save();
        return $comment;
    }

    public function delete(int $commentId): bool|null
    {
        return Comment::query()
            ->findOrFail($commentId)
            ->delete();
    }

    public function countCommentsByPostId(int $postId): int
    {
        return Comment::query()
            ->where('post_id', '=', $postId)
            ->count();
    }

    public function countCommentsByUserId(int $userId): int
    {
        return Comment::query()
            ->where('user_id', '=', $userId)
            ->count();
    }

    public function countComments(): int
    {
        return Comment::query()
            ->count();
    }

    public function commentIsInActivePost(int $commentId): bool
    {
        return Comment::query()
            ->select(['posts.is_active'])
            ->join('posts', 'posts.id', '=', 'comments.post_id')
            ->where('comments.id', '=', $commentId)
            ->first()['is_active'];
    }

    public function commentBelongsToUser(int $commentId, int $userId): bool
    {
        $comment = Comment::query()
            ->findOrFail($commentId);

        return $comment['user_id'] === $userId;
    }
}
