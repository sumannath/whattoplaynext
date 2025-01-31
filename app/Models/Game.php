<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Game extends Model
{
    use Searchable;

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}
