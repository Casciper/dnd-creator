<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SortedByPublicationScopeTrait
{
    public function scopePublicationSorted(Builder $query, $direction = 'desc'): Builder
    {
        return $query->orderBy('publication_date', $direction);
    }
}
