<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_will_calculate_remaining_letters_from_game()
    {
        $game = Game::factory()->create();
        $game->letters = 'dictionaryabcdefg';
        $game->save();

        $game->submissions()->create([
            'word' => 'dictionary',
        ]);

        $service = new GameService($game);
        $letters = $service->calculateRemainingLetters();
        $this->assertIsArray($letters);

        $this->assertSame([10 => 'a', 11 => 'b', 12 => 'c', 13 => 'd', 14 => 'e', 15 => 'f', 16 => 'g'], $letters);
        // maintaing indexes
    }
}
