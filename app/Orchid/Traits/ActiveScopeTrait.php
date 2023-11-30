<?php

    namespace App\Orchid\Traits;

    use Illuminate\Database\Eloquent\Builder;

    trait ActiveScopeTrait
    {
        public function scopeActive(Builder $query): Builder
        {
            return $query->where('is_active','=',  true);
        }
    }
