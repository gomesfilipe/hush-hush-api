<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function store(array $attributes): object
    {
        $attributes['password'] = Hash::make($attributes['password']);

        return User::query()
            ->create($attributes)
            ->fresh();
    }

    public function get(array $params = []): LengthAwarePaginator
    {
        $count = $params['count'] ?? 50;
        $username = $params['username'] ?? null;
        $email = $params['email'] ?? null;

        return User::query()
            ->when($username, fn (Builder $query) => $query
                ->where('username', 'LIKE', "%$username%" )
            )
            ->when($email, fn (Builder $query) => $query
                ->where('email', 'LIKE', "%$email%" )
            )
            ->withCount('posts')
            ->withCount('comments')
            ->paginate($count);
    }

    public function findOrFail(int $userId): object
    {
        return User::query()
            ->withCount('posts')
            ->withCount('comments')
            ->findOrFail($userId);
    }


    public function update(int $userId, array $attributes): object
    {
        if(isset($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        $user = User::query()
            ->findOrFail($userId);

        $user->fill($attributes)->save();
        return $user;
    }

    public function delete(int $userId): bool|null
    {
        return User::query()
            ->where('id', '=', $userId)
            ->delete();
    }

    public function getUsersWithMostComments(int $count = 3): array
    {
        return $this->get([
            'count' => $count,
            'order_by' => 'comments_count DESC',
        ])->toArray()['data'];
    }

    public function getUsersWithMostPosts(int $count = 3): array
    {
        return $this->get([
            'count' => $count,
            'order_by' => 'posts_count DESC',
        ])->toArray()['data'];
    }

    public function countUsers(): int
    {
        return User::query()
            ->count();
    }
}
