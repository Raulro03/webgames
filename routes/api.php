<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ForumController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\PlatformController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/games', [GameController::class, 'index']);
Route::get('/games/{game}', [GameController::class, 'show']);

Route::get('/platforms', [PlatformController::class, 'index']);
Route::get('/platforms/{platform}', [PlatformController::class, 'show']);

Route::get('/posts', [ForumController::class, 'index']);
Route::get('/posts/{post}', [ForumController::class, 'show']);

Route::get('/comments', [CommentController::class, 'index']);
Route::get('/comments/{comment}', [CommentController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/posts', [ForumController::class, 'store']);
    Route::patch('/posts/{post}', [ForumController::class, 'update']);
    Route::delete('/posts/{post}', [ForumController::class, 'destroy']);

    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
});
