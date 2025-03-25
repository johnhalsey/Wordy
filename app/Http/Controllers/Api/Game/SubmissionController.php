<?php

namespace App\Http\Controllers\Api\Game;

use App\Models\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGameSubmissionRequest;

class SubmissionController extends Controller
{
    // store a new word submission against a game
    public function store(StoreGameSubmissionRequest $request, Game $game)
    {
        // the word played will containers valid letters from the game,
        // now we check if it is a valid english word


    }
}
