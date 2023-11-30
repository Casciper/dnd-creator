<?php

declare(strict_types=1);

use App\Enums\OrchidRoutes;
use App\Http\Controllers\FilesController;
use App\Orchid\Helpers\OrchidHelper;
use App\Orchid\Screens\Articles\ArticleCategoryEdit;
use App\Orchid\Screens\Articles\ArticleCategoryList;
use App\Orchid\Screens\Articles\ArticleEdit;
use App\Orchid\Screens\Articles\ArticleList;
use App\Orchid\Screens\Classes\ClassEdit;
use App\Orchid\Screens\Classes\ClassList;
use App\Orchid\Screens\ConfiguratorEdit;
use App\Orchid\Screens\Genders\GenderEdit;
use App\Orchid\Screens\Genders\GenderList;
use App\Orchid\Screens\Pages\PageList;
use App\Orchid\Screens\Pages\PageEdit;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Races\RaceEdit;
use App\Orchid\Screens\Races\RaceList;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Seo\RobotsScreen;
use App\Orchid\Screens\Seo\SeoScreen;
use App\Orchid\Screens\Seo\SitemapScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::prefix('systems')->group(function () {
    Route::post('files', [FilesController::class, 'upload'])->name('systems.files.upload');
});

// Main
Route::screen('/home', PlatformScreen::class)->name('platform.main');
Route::screen('/robots', RobotsScreen::class)->name(OrchidRoutes::ROBOTS->base());
Route::screen('/sitemap', SitemapScreen::class)->name(OrchidRoutes::SITEMAP->base());
Route::screen('/seo', SeoScreen::class)->name(OrchidRoutes::SEO->base());
Route::screen('/configurator', ConfiguratorEdit::class)->name(OrchidRoutes::CONFIGURATOR->base());

Route::screen('/pages', PageList::class)->name('platform.pages.list');
Route::screen('/pages/{item}', PageEdit::class)->name('platform.pages.edit');

OrchidHelper::setAdminRoutes(OrchidRoutes::ARTICLE_CATEGORIES->value, ArticleCategoryList::class, ArticleCategoryEdit::class);
OrchidHelper::setAdminRoutes(OrchidRoutes::ARTICLES->value, ArticleList::class, ArticleEdit::class);
OrchidHelper::setAdminRoutes(OrchidRoutes::RACES->value, RaceList::class, RaceEdit::class);
OrchidHelper::setAdminRoutes(OrchidRoutes::GENDER->value, GenderList::class, GenderEdit::class);
OrchidHelper::setAdminRoutes(OrchidRoutes::CHCLASS->value, ClassList::class, ClassEdit::class);

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)->name('platform.profile')->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)->name('platform.systems.users')->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));
