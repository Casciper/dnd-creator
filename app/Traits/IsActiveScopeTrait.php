<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IsActiveScopeTrait
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', '=', true);
    }
}
