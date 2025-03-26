<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Word;
use Inertia\Testing\AssertableInertia;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_anyone_can_start_a_new_game()
    {
        $word = Word::factory()->create();

        $this->assertDatabaseCount('games', 0);

        $this->call(
            'GET',
            route('game.start')
        )->assertStatus(200)
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Game')
            );

        $this->assertDatabaseCount('games', 1);
        $this->assertDatabaseHas('games', [
            'word_id' => $word->id,
        ]);
    }
}
