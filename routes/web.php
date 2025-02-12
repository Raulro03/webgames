<?php


use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Pages\PageCharactersController;
use App\Http\Controllers\Pages\PageGamesController;
use App\Http\Controllers\Pages\PagePlatformsController;
use App\Http\Controllers\Pages\PageVersusController;
use App\Http\Controllers\Pages\PageWelcomeController;
use App\Livewire\TopGames;
use App\Livewire\TopPlatforms;
use Illuminate\Support\Facades\Route;

Route::get('/', PageWelcomeController::class)->name('welcome');

Route::get('/games', [PageGamesController::class, 'index'])->name('games');

Route::get('/characters', [PageCharactersController::class, 'index'])->name('characters');

Route::get('/platforms', [PagePlatformsController::class, 'index'])->name('platforms');

Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/forum/{category}', [ForumController::class, 'showPostsOfCategory'])->name('forum.category');
Route::get('/forum/{post}', [ForumController::class, 'showPost'])->name('forum.show');

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

    Route::post('/forum/{category}/{post}/comment', [CommentController::class, 'store'])->name('forum.comment.store');
    Route::post('/forum/{category}/store', [ForumController::class, 'storePost'])->name('forum.post.store');
    Route::patch('/forum/{category}/{post}/update', [ForumController::class, 'updatePost'])->name('forum.post.update');
    Route::delete('/forum/{category}/{post}/destroy', [ForumController::class, 'destroyPost'])->name('forum.post.destroy');
    //Route::get('/top-platforms', TopPlatforms::class)->name('top-platforms');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
