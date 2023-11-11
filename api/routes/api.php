<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\EvaluationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['setLocale'])->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // User
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/user', [UserController::class, 'showByLoggedUser']);
        Route::get('/user/{userId}', [UserController::class, 'show']);

        Route::put('/user', [UserController::class, 'update']);
        Route::post('/user-profile-picture', [UserController::class, 'uploadProfilePicture']);
        Route::patch('/user-password', [UserController::class, 'updatePassword']);

        Route::delete('/user', [UserController::class, 'destroyByLoggedUser']);
        Route::delete('/user/{userId}', [UserController::class, 'destroy']);

        Route::post('/logout-user', [UserController::class, 'logout']);

        // Posts
        Route::get('/posts', [PostController::class, 'index']);
        Route::get('/user/posts', [PostController::class, 'indexByLoggedUser']);
        Route::get('/user/{userId}/posts', [PostController::class, 'indexByUserId']);
        Route::get('/post/{postId}', [PostController::class, 'show']);

        Route::post('/post', [PostController::class, 'store']);

        Route::put('/post/{postId}', [PostController::class, 'update']);
        Route::patch('/post-is-active/{postId}', [PostController::class, 'updateIsActive']);

        Route::delete('/post/{postId}', [PostController::class, 'destroy']);

        // Comments
        Route::get('/post/{postId}/comments', [CommentController::class, 'indexByPostId']);

        Route::post('/post/{postId}/comment', [CommentController::class, 'store']);

        Route::put('/comment/{commentId}', [CommentController::class, 'update']);

        Route::delete('/comment/{commentId}', [CommentController::class, 'destroy']);

        // Dashboards
        Route::get('/dashboards', [HomeController::class, 'dashboards']);

        // Evaluations
        Route::post('/comment/{commentId}/like', [EvaluationController::class, 'setLike']);
        Route::post('/comment/{commentId}/dislike', [EvaluationController::class, 'setDisLike']);
        Route::post('/comment/{commentId}/none', [EvaluationController::class, 'setNone']);
    });

    Route::post('/user', [UserController::class, 'store']);
    Route::post('/login-user', [UserController::class, 'login']);
});




