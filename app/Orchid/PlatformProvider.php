<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Enums\OrchidRoutes;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [

            Menu::make('Публикации')->icon('feed')->list([
                Menu::make('Статьи')->route(OrchidRoutes::ARTICLES->list())->icon('book-open'),
                Menu::make('Категории статей')->route(OrchidRoutes::ARTICLE_CATEGORIES->list())->icon('list'),
            ]),

            Menu::make('Страницы')->route(OrchidRoutes::INFO_PAGES->list())->icon('info'),
            Menu::make('Расы')->route(OrchidRoutes::RACES->list())->icon('user'),
            Menu::make('Гендер')->route(OrchidRoutes::GENDER->list())->icon('user'),
            Menu::make('Классы')->route(OrchidRoutes::CHCLASS->list())->icon('user'),

            Menu::make('Настройки SEO')->icon('globe')->list([
                Menu::make('SEO')->route(OrchidRoutes::SEO->base())->icon('docs'),
                Menu::make('Robots.txt')->route(OrchidRoutes::ROBOTS->base())->icon('android'),
                Menu::make('Sitemap.xml')->route(OrchidRoutes::SITEMAP->base())->icon('map'),
            ]),
            Menu::make('Настройки сайта')->route(OrchidRoutes::CONFIGURATOR->base())->icon('settings'),

            Menu::make(__('Users'))->icon('user')->route('platform.systems.users')
                ->permission('platform.systems.users')->title(__('Access rights')),

            Menu::make(__('Roles'))->icon('lock')->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))->route('platform.profile')->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
