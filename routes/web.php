<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('game', [\App\Http\Controllers\GameController::class, 'start'])
    ->name('game.start');
