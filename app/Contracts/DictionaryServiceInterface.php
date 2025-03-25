<?php

namespace App\Contracts;

use HttpResponse;

interface DictionaryServiceInterface
{
    public function validate(string $key): bool;
}
