<?php


use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Pages\PageCharactersController;
use App\Http\Controllers\Pages\PageGamesController;
use App\Http\Controllers\Pages\PagePlatformsController;
use App\Http\Controllers\Pages\PageVersusController;
use App\Http\Controllers\Pages\PageWelcomeController;
use App\Livewire\TopGames;
use Illuminate\Support\Facades\Route;

Route::get('/', PageWelcomeController::class)->name('welcome');

Route::get('/games', [PageGamesController::class, 'index'])->name('games');

Route::get('/characters', [PageCharactersController::class, 'index'])->name('characters');

Route::get('/platforms', [PagePlatformsController::class, 'index'])->name('platforms');

Route::get('/forum', [ForumController::class, 'index'])->name('forum');
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

    Route::get('/games/{game}', [PageGamesController::class, 'show'])->name('games.show');
    Route::get('/characters/{character}', [PageCharactersController::class, 'show'])->name('characters.show');
    Route::get('/platforms/{platform}', [PagePlatformsController::class, 'show'])->name('platforms.show');

    Route::get('/versus', [PageVersusController::class, 'index'])->name('versus');
    Route::get('/top-games', TopGames::class)->name('top-games');

    Route::post('/forum/{post}/comment', [CommentController::class, 'store'])->name('forum.comment.store');
    Route::get('/forum/my-posts', [ForumController::class, 'myPosts'])->name('forum.my-posts');
    Route::resource('forum/post', ForumController::class)
        ->only(['show','create', 'store', 'edit', 'update', 'destroy']);


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
