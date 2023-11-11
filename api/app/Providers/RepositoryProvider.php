<?php

namespace App\Providers;

use App\Repositories\EvaluationRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\EvaluationRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        PostRepositoryInterface::class => PostRepository::class,
        CommentRepositoryInterface::class => CommentRepository::class,
        EvaluationRepositoryInterface::class => EvaluationRepository::class
    ];
}
