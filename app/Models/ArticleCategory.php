<?php

namespace App\Models;

use App\Orchid\Filters\DateCreatedFilter;
use App\Orchid\Filters\IsActiveFilter;
use App\Traits\CodeScopeTrait;
use App\Traits\IsActiveScopeTrait;
use App\Traits\SortedScopeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Types\Like;

class ArticleCategory extends ProtoModel
{
    use IsActiveScopeTrait;
    use SortedScopeTrait;
    use CodeScopeTrait;

    public const TABLE_NAME = 'article_categories';
    protected $table = self::TABLE_NAME;
    protected $allowedSorts = ['is_active', 'sort', 'title', 'code', 'created_at'];
    protected $allowedFilters = [
        'title' => Like::class,
        'code' => Like::class,
        'is_active' => IsActiveFilter::class,
        'created_at' => DateCreatedFilter::class
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'category_id', 'id');
    }

    public function rules()
    {
        return config('presets.orchid.validators.article-category.rules');
    }
}
