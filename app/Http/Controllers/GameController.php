<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Word;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function start(Request $request)
    {
        // get a new word that hasn't been used, or hasn't been used much
        $word = Word::withCount('games')
            ->orderBy('games_count', 'asc')
            ->first();

        // Add 6 more random chars
        $gameLetters = $word->word . Str::substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 6);
        // shuffle them all up
        $gameLetters = str_shuffle($gameLetters);

        $game = $word->games()->create([
            'letters' => $gameLetters,
        ]);

        return Inertia::render('Game', [
            'letters' => str_split($gameLetters),
            'gameId' => $game->id,
        ]);
    }
}
