<?php

namespace App\Adapters;

use Illuminate\Support\Facades\Http;
use App\Contracts\DictionaryInterface;

class DictionaryApiAdapter
{
    public function get($word)
    {
        return Http::get('https://api.dictionaryapi.dev/api/v2/entries/en/' . $word)->throw();
    }
}
