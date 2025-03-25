<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Submission;

class GameService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private readonly Game $game)
    {
        //
    }

    public function calculateRemainingLetters(): array
    {
        $gameLetters = str_split($this->game->letters);

        $this->game->submissions->each(function (Submission $submission) use (&$gameLetters) {
            foreach (str_split($submission->word) as $letter) {
                // no need to check if the letter exisetd here, that should already have been checked when THAT word was submitted
                // find the letter in $gameLetters and remove it
                if (($key = array_search($letter, $gameLetters)) !== false) {
                    unset($gameLetters[$key]);
                }
            }
        });

        return $gameLetters;
    }
}
