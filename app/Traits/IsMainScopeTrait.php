<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IsMainScopeTrait
{
    public function scopeIsMain(Builder $query): Builder
    {
        return $query->where('is_main', '=', true);
    }
}
