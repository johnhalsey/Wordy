# Wordy Game
Simple word game built with Laravel 12 and Vue.js 3

## Local Installation
You will need a local environment running, such as Laravel Valet, Herd, etc.

- Clone the repo: `git clone git@github.com:johnhalsey/Wordy.git`
- `cd Wordy`
- `composer install`
- `npm install`
- `cp .env.example .env`
- Create a local database and update the configuration in the .env file if needed
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed` // This will seed the database with valid words
- `npm run dev`

## Running Tests
You can run the test suite with:

```
php artisan test
```

## Solution
How does the game work?

The database has a words table, which is seeded with 200 valid 9-character words.
When the user starts a new game, we randomly select one of these words from the database, add six more random characters, shuffle them, and send them to the Game.vue page.

We use the words table to ensure there is at least one 9-character word available to play—potentially more, with the addition of random characters.

When a user submits a word, server-side validation ensures:

All the letters in the word exist in the available game letters.

The letters haven't already been used in previous submissions for that game.

If the letters are valid, we then call https://dictionaryapi.dev/ to verify that it is a real word. If it's not, we return an error.

If the word is valid, we insert a row into the submissions table with the game ID, the word, and the score (the number of letters used).

With every valid submission, we gray out the used letters in the UI, indicating that they cannot be used again.

## High Score
When a user visits the high-score page, we display the top 10 submissions, ordered by score.

