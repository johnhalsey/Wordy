<?php

namespace Tests\Feature\Api\Game;

use App\Models\Word;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubmissionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_will_fail_if_word_missing_from_submission()
    {
        $word = Word::factory()->create();
        $game = Game::factory()->create([
            'word_id' => $word->id,
        ]);

        $this->json(
            'POST',
            route('api.game.submission.store', ['game' => $game]),
            [
                // no word
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors(['word'])
            ->assertJsonFragment([
                'errors' => [
                    'word' => ['The word field is required.']
                ]
            ]);
    }

    public function test_validation_will_fail_if_word_not_a_string()
    {
        $word = Word::factory()->create();
        $game = Game::factory()->create([
            'word_id' => $word->id,
        ]);

        $this->json(
            'POST',
            route('api.game.submission.store', ['game' => $game]),
            [
                'word' => 1234
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors(['word'])
            ->assertJsonFragment([
                'errors' => [
                    'word' => ['The word field must be a string.']
                ]
            ]);
    }

    public function test_validation_will_fail_if_letters_in_word_not_in_game_letters()
    {
        $word = Word::factory()->create();
        $game = Game::factory()->create([
            'word_id' => $word->id,
        ]);
        $game->letters = 'abcdefghijk';
        $game->save();

        $this->json(
            'POST',
            route('api.game.submission.store', ['game' => $game]),
            [
                'word' => 'abcdefz'
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors(['word'])
            ->assertJsonFragment([
                'errors' => [
                    'word' => [
                        'z is not available to use!',
                    ]
                ]
            ]);
    }

    public function test_validation_will_fail_if_letters_in_word_already_used_in_previous_submission()
    {
        $word = Word::factory()->create();
        $game = Game::factory()->create([
            'word_id' => $word->id,
        ]);
        $game->letters = 'abcdefghijk';
        $game->save();

        $game->submissions()->create([
            'word' => 'abc',
            'score' => 3
        ]);

        $this->json(
            'POST',
            route('api.game.submission.store', ['game' => $game]),
            [
                'word' => 'fgial'
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors(['word'])
            ->assertJsonFragment([
                'errors' => [
                    'word' => [
                        'a is not available to use!',
                        'l is not available to use!',
                    ]
                ]
            ]);
    }

}
