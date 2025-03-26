<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use App\Services\GameService;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreGameSubmissionRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'word' => ['required', 'string'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->count() > 0) {
                    // don't run this if we know the word is already invalid
                    return;
                }

                // get the game letters from the route
                $game = $this->route('game');

                $gameService = new GameService($game);
                $remainingLetters = $gameService->calculateRemainingLetters();

                // what's left is what we have to play with, check each letter in the submitted word
                // is available to use
                foreach(str_split($this->input('word')) as $letter) {
                    if (array_search(Str::lower($letter), $remainingLetters) === false) {
                        // letter not in remaining letters
                        $validator->errors()->add(
                            'word',
                            $letter . ' is not available to use!'
                        );
                    }
                }

            }
        ];
    }
}
