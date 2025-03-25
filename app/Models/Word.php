<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Word extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
