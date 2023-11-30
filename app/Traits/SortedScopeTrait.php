<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SortedScopeTrait
{
    public function scopeSorted(Builder $query, $direction = 'asc'): Builder
    {
        return $query->orderBy('sort', $direction);
    }
}
