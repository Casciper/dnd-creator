<?php

namespace App\Helpers;

use App\Enums\ClientRoutes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

class CommonHelper
{
    public static function isEmpty($mixed): bool
    {
        if (is_array($mixed)) {
            $flatten = Arr::flatten($mixed);
            $filtered = collect($flatten)->filter(fn($item) => !empty($item));
            return $filtered->isEmpty();
        }
        return empty($mixed);
    }

    public static function getPreset(string $title, ?string $block = null)
    {
        $data = config('presets.' . $title);
        $data = $data ?? [];
        return (is_null($block) || empty($data)) ? $data : $data[$block];
    }

    public static function setBreadCrumbs(string $route, string $parentRoute, string $title, array $params): void
    {
        Breadcrumbs::for($route, fn(Trail $t) => $t->parent($parentRoute)
            ->push($title, route($route, $params)));
    }

    public static function getBreadCrumbs(Trail $t, array $crumbs)
    {
        $t->parent(ClientRoutes::MAIN_PAGE);
        foreach ($crumbs as $crumb) {
            $t->push($crumb['title'], route($crumb['route'], $crumb['params'] ?? []));
        }
        return $t;
    }

    public static function setCrumbs($crumbs): void
    {
        Breadcrumbs::for(Route::currentRouteName(), fn(Trail $t) => CommonHelper::getBreadCrumbs($t, $crumbs));
    }
}
