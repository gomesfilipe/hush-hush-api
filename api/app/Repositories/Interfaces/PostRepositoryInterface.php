<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function store(array $attributes): object;

    public function get(array $params = []): LengthAwarePaginator;

    public function findOrFail(int $postId): object;

    public function update(int $postId, array $attributes): object;

    public function delete(int $postId): bool|null;

    public function countPostsByUserId(int $userId): int;

    public function getMostCommentedPosts(int $count = 3): array;

    public function countPosts(): int;

    public function isActivePost(int $postId): bool;

    public function postBelongsToUser(int $postId, int $userId): bool;
}
