<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface CommentRepositoryInterface
{
    public function store(array $attributes): object;

    public function get(array $params = []): LengthAwarePaginator;

    public function getByPostId(int $postId, array $params = []): LengthAwarePaginator;

    public function update(int $commentId, array $attributes): object;

    public function delete(int $commentId): bool|null;

    public function countCommentsByPostId(int $postId): int;

    public function countCommentsByUserId(int $userId): int;

    public function countComments():int;

    public function commentIsInActivePost(int $commentId): bool;

    public function commentBelongsToUser(int $commentId, int $userId): bool;
}
