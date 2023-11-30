<?php

namespace App\Models;

use App\Orchid\Traits\ActiveScopeTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Route;
use Kalnoy\Nestedset\NodeTrait;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

class Page extends ProtoModel
{
    use ActiveScopeTrait;
    use NodeTrait;

    public const TABLE_NAME = 'pages';
    protected $table = self::TABLE_NAME;

    protected $casts = [
        'data' => 'array'
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->active();
    }

    public function removableChildren()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id')->active();
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    public function getActivityStatusAttribute(): string
    {
        return $this->is_active ? 'Да' : 'Нет';
    }

    public function getPageType(): string
    {
        return match ($this->type){
            'page' => 'page',
            'link' => 'link',
            default => 'template',
        };
    }
    private function getParentsList(array &$list, ?Page $parentPage): void
    {
        if (is_null($parentPage)) {
            return;
        }
        $list[] = $this->setDataForBreadCrumbs($parentPage);

        $this->getParentsList($list, $parentPage->parentRecursive);
    }

    private function setDataForBreadCrumbs(Page $page): array
    {
        return [
            'title' => $page->name,
            'route' => 'web.pages.page',
            'params' => $page->uri
        ];
    }

    public function setBreadCrumbs(): void
    {
        $crumbs = [];
        $this->getParentsList($crumbs, $this->parentRecursive()->first());

        $crumbs = array_reverse($crumbs);
        $crumbs[] = $this->setDataForBreadCrumbs($this);

        $this->setCrumbs($crumbs);
    }

    public function getBreadCrumbsTest(Trail $t, array $crumbs): Trail
    {
        $t->parent('web.main.page');
        foreach ($crumbs as $crumb) {
            $t->push($crumb['title'], route($crumb['route'], $crumb['params'] ?? []));
        }
        return $t;
    }

    public function setCrumbs($crumbs): void
    {
        Breadcrumbs::for(Route::currentRouteName(), fn(Trail $t) => $this->getBreadCrumbsTest($t, $crumbs));
    }
}
