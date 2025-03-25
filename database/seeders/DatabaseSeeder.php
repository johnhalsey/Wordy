<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed some words into the words table
        $words = Http::get('https://random-word-api.vercel.app/api?words=200&length=9')->json();
        foreach ($words as $word) {
            DB::table('words')->insert(['word' => $word]);
        }
    }
}
