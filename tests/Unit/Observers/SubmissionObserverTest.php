<?php

namespace Tests\Unit\Observers;

use Tests\TestCase;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_will_set_score_for_word_when_creating()
    {
        $game = Game::factory()->create();
        $submission = $game->submissions()->create([
            'word' => 'hello'
        ]);
        $this->assertSame(5, $submission->score);
    }
}
