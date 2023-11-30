<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SlugScopeTrait
{
    public function scopeCode(Builder $query, $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
