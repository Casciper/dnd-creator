<?php

namespace App\Enums;

use App\Orchid\Layouts\Pages\AboutCompanyPageLayout;
use App\Orchid\Layouts\Pages\ContactsPageLayout;
use App\Orchid\Layouts\Pages\CooperationPageLayout;
use App\Orchid\Layouts\Pages\LinkLayout;
use App\Orchid\Layouts\Pages\PageLayout;

enum PagesTypes: string
{
    // Типы страниц pages и link - системные
    case PAGE = 'page';
    case LINK = 'link';

    // Шаблоны страниц
    case PAGE_ABOUT = 'about';
    case PAGE_CONTACTS = 'contacts';
    case PAGE_COOPERATION = 'cooperation';


    public function getLayout()
    {
        return match ($this->value) {
            self::PAGE->value => new PageLayout(),
            self::LINK->value => new LinkLayout(),
            self::PAGE_ABOUT->value => new AboutCompanyPageLayout(),
            self::PAGE_CONTACTS->value => new ContactsPageLayout(),
            self::PAGE_COOPERATION->value => new CooperationPageLayout(),
        };
    }

    public function getTemplate()
    {
        return match ($this->value) {
            self::PAGE_ABOUT->value => 'pages.about',
            self::PAGE_CONTACTS->value => 'pages.contacts',
            self::PAGE_COOPERATION->value => 'pages.cooperation',
            default => 'pages.default'
        };
    }

    public function getEditTitle()
    {
        return match ($this->value) {
            self::PAGE->value => 'Редактирование страницы',
            self::LINK->value => 'Редактирование ссылки',
            self::PAGE_ABOUT->value => 'Редактирование страницы по шаблону - О нас',
            self::PAGE_CONTACTS->value => 'Редактирование страницы по шаблону - Контакты',
            self::PAGE_COOPERATION->value => 'Редактирование страницы по шаблону - Сотрудничество',
        };
    }

    public function getTitle()
    {
        return match ($this->value) {
            self::PAGE->value => 'Страница',
            self::LINK->value => 'Ссылка',
            self::PAGE_ABOUT->value => 'О нас',
            self::PAGE_CONTACTS->value => 'Контакты',
            self::PAGE_COOPERATION->value => 'Сотрудничество',
        };
    }

    public static function getOptions(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            if (!in_array($case->value, [self::PAGE->value, self::LINK->value]))
            $array[$case->value] = $case->getTitle();
        }
        return $array;
    }

}
