<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

class Game extends Model
{
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();
        if(array_key_exists('alternative_names', $array)) {
            return [
                'id'   => $this->getKey(),
                'name' => $this->name,
                'category' => $this->category,
                'alternative_names' => collect($this->alternative_names)->pluck('name')->toArray()
            ];
        } else {
            return [
                'id'   => $this->getKey(),
                'category' => $this->category,
                'name' => $this->name,
            ];
        }
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
