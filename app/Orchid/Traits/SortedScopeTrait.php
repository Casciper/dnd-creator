<?php

    namespace App\Orchid\Traits;

    use Illuminate\Database\Eloquent\Builder;

    trait SortedScopeTrait
    {
        public function scopeSorted(Builder $query): Builder
        {
            return $query->orderByDesc('sort');
        }
    }
