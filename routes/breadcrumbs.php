<?php

use App\Enums\OrchidRoutes;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

// ======= CLIENT
$main = 'web.main.page';
$articles = 'web.articles.list';

// Main page
Breadcrumbs::for($main, fn(Trail $t) => $t->push('Главная', route($main)));

// /articles
Breadcrumbs::for($articles, fn(Trail $t) => $t->parent($main)->push('Статьи', route($articles)));

// ADMIN DASHBOARD =============
$admin = 'platform.main';

// /admin/main
Breadcrumbs::for($admin, fn(Trail $t) => $t->push('Главная', route($admin)));

$routesEnums = OrchidRoutes::cases();
foreach ($routesEnums as $enum) {
    if ($enum->isSingle()) {
        Breadcrumbs::for($enum->base(), fn(Trail $t) => $t->parent($admin)
            ->push($enum->getTitle(), route($enum->base())));
    } else {
        Breadcrumbs::for($enum->list(), fn(Trail $t) => $t->parent($admin)
            ->push($enum->getTitle(), route($enum->list())));
    }
}

