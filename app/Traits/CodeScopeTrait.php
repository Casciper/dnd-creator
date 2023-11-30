<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CodeScopeTrait
{
    public function scopeCode(Builder $query, $code): Builder
    {
        return $query->where('code', $code);
    }
}
