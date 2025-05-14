<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Pages\PageCharactersController;
use App\Http\Controllers\Pages\PageGamesController;
use App\Http\Controllers\Pages\PagePlatformsController;
use App\Http\Controllers\Pages\PageVersusController;
use App\Http\Controllers\Pages\PageWelcomeController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TrashPostsController;
use App\Http\Controllers\User\UserDashboardController;
use App\Livewire\PlatformsManager;
use App\Livewire\TopGames;
use Illuminate\Support\Facades\Route;

Route::get('/', PageWelcomeController::class)->name('welcome');

Route::get('/games', [PageGamesController::class, 'index'])->name('games');

Route::get('/characters', [PageCharactersController::class, 'invoke'])->name('characters');

Route::get('/platforms', [PagePlatformsController::class, 'invoke'])->name('platforms');

Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/forum/my-posts', [ForumController::class, 'myPosts'])->name('forum.my-posts')
    ->middleware('auth');
Route::get('/forum/{category}', [ForumController::class, 'showPostsOfCategory'])->name('forum.category');

Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::resource('/games', PageGamesController::class)
        ->only(['create', 'edit', 'destroy'])->middleware('role:admin');
    Route::get('/games/{game}', [PageGamesController::class, 'show'])->name('games.show');

    Route::get('/game/{id}/pdf', [PDFController::class, 'gamePDF'])->name('game.pdf');
    Route::get('/platform/{id}/pdf', [PDFController::class, 'platformPDF'])->name('platform.pdf');

    Route::get('/versus', [PageVersusController::class, 'index'])->name('versus');
    Route::get('/top-games', TopGames::class)->name('top-games');

    Route::post('/forum/{post}/comment', [CommentController::class, 'store'])->name('forum.comment.store');
    Route::resource('forum/post', ForumController::class)
        ->only(['show','create', 'store', 'edit', 'update', 'destroy']);

    Route::get('/posts/trash', [TrashPostsController::class, 'showTrashPosts'])->name('posts.trash-posts');
    Route::patch('/posts/trash/{id}/restore', [TrashPostsController::class, 'restorePost'])->name('posts.restore');
    Route::delete('/posts/trash/{id}/force-delete', [TrashPostsController::class, 'forceDeletePost'])->name('posts.forceDelete');


    Route::resource('/comments/{post}/comment', CommentController::class)->except(['index', 'show']);
    Route::get('/my-comments', [CommentController::class, 'myComments'])->name('comments.my-comments');
    Route::get('/comments/{post}/{comment?}/reply', [CommentController::class, 'create'])->name('replies.create');
    Route::post('/comments/{post}/{comment?}/reply', [CommentController::class, 'store'])->name('replies.store');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/user/generate-tokens', [UserDashboardController::class, 'generateTokens'])->name('user.generate.tokens');


    Route::middleware('role:admin')->group(function () {
        Route::post('/admin/dashboard/delete-archived-posts', [AdminDashboardController::class, 'deleteArchivedPosts'])
            ->name('dashboard.deleteArchivedPosts');
        Route::post('/admin/dashboard/CleanTrashedPosts', [AdminDashboardController::class, 'cleanTrashPosts'])
            ->name('dashboard.CleanTrashedPosts');
        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users-delete');
        Route::post('/admin/users/{user}/make-admin', [AdminUserController::class, 'makeAdmin'])->name('admin.users-make-admin');
    });

});

