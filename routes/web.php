<?php


use App\Http\Controllers\Pages\PageCharactersController;
use App\Http\Controllers\Pages\PageForumController;
use App\Http\Controllers\Pages\PageGamesController;
use App\Http\Controllers\Pages\PagePlatformsController;
use App\Http\Controllers\Pages\PageVersusController;
use App\Http\Controllers\Pages\PageWelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', PageWelcomeController::class)->name('welcome');
Route::get('/games', [PageGamesController::class, 'index'])->name('games');
Route::get('/characters', [PageCharactersController::class, 'index'])->name('characters');
Route::get('/platforms', [PagePlatformsController::class, 'index'])->name('platforms');
Route::get('/forum', [PageForumController::class, 'index'])->name('forum');
Route::get('/versus', [PageVersusController::class, 'index'])->name('versus');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
