<?php

namespace App\Http\Controllers\Api\Game;

use App\Models\Game;
use App\Services\GameService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Contracts\DictionaryServiceInterface;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreGameSubmissionRequest;

class SubmissionController extends Controller
{
    public function __construct(private readonly DictionaryServiceInterface $dictionaryService)
    {
    }

    // store a new word submission against a game
    public function store(StoreGameSubmissionRequest $request, Game $game)
    {
        // the word played will containers valid letters from the game,
        // now we check if it is a valid english word
        if (!$this->dictionaryService->validate($request->input('word'))) {
            throw ValidationException::withMessages([
                'word' => ['Not a valid word.'],
            ]);
        }

        // save the submission against the game
        $game->submissions()->create([
            'word' => $request->input('word'),
        ]);

        $game->refresh();
        // send back remaing letters
        $gameService = new GameService($game);
        $letters = $gameService->calculateRemainingLetters();

        return response()->json([
            'remainingLetters' => $letters,
            'gameId'           => $game->id,
            'submissions'      => $game->submissions
        ], Response::HTTP_CREATED);
    }
}
