<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Adapters\DictionaryApiAdapter;
use App\Contracts\DictionaryServiceInterface;

class WordValidationService implements DictionaryServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private readonly DictionaryApiAdapter $adapter)
    {
    }

    public function validate(string $word): bool
    {
        try{
            return $this->adapter->get($word)->status() == 200;
        } catch(\Exception $exception){
            // it failed, log our the error for looking at later, tell the user it is not valid
            Log::error($exception->getMessage());
            return false;
        }
    }
}
