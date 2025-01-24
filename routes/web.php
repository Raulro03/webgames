<?php

use App\Http\Controllers\Pages\PageGamesController;
use App\Http\Controllers\Pages\PageWelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', PageWelcomeController::class)->name('welcome');
Route::get('/games', PageGamesController::class)->name('games');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
