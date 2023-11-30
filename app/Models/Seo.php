<?php

namespace App\Models;

use App\Orchid\Filters\DateCreatedFilter;
use App\Orchid\Filters\IsActiveFilter;
use App\Traits\IsActiveScopeTrait;
use App\Traits\SortedScopeTrait;
use Orchid\Filters\Types\Like;

class Seo extends ProtoModel
{
    public const TABLE_NAME = 'seos';
    protected $table = self::TABLE_NAME;
    protected $allowedSorts = ['is_active', 'sort', 'title', 'created_at'];
    protected $allowedFilters = [
        'is_active' => IsActiveFilter::class,
        'title' => Like::class,
        'code' => Like::class,
        'sort' => Like::class,
        'created_at' => DateCreatedFilter::class,
    ];

    use IsActiveScopeTrait;
    use SortedScopeTrait;

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->text;
    }
}

