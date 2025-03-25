<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/game/{game}/submit', [\App\Http\Controllers\Api\Game\SubmissionController::class, 'store'])
    ->name('api.game.submission.store');
