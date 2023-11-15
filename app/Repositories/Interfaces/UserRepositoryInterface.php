<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function store(array $attributes): object;

    public function get(array $params = []): LengthAwarePaginator;

    public function findOrFail(int $userId): object;

    public function update(int $userId, array $attributes): object;

    public function delete(int $userId): bool|null;

    public function getUsersWithMostComments(int $count = 3): array;

    public function getUsersWithMostPosts(int $count = 3): array;

    public function countUsers(): int;
}
