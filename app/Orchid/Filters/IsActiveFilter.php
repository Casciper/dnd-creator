<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class IsActiveFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Активность';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['filter'];
    }

    /**
     * Apply to a given Eloquent query builder.
     * @param Builder $builder
     * @return Builder
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface
     */
    public function run(Builder $builder): Builder
    {
        $filter = $this->request->get('filter');
        if (empty($filter['is_active'])) {
            return $builder;
        }

        $value = $filter['is_active'] === 'Да';
        return $builder->where('is_active', '=', $value);
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [];
    }
}
