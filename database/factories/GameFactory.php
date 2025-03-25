<?php

namespace Database\Factories;

use App\Models\Word;
use App\Models\Game;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'word_id' => function () {
                return Word::factory()->create()->id;
            },
            'letters' => $this->faker->word(), // This will get overridden below
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Game $game) {
            $gameLetters = $game->word->word . Str::substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 6);
            $game->letters = str_shuffle($gameLetters);
            $game->save();
        });
    }
}
