<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ReadyToPublicationScopeTrait
{
    public function scopePublicated(Builder $query)
    {
        return $query->where('publication_date', '<=', now()->toDateTime());
    }
}
