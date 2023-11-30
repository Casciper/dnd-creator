<?php

namespace App\Enums;

use Exception;

enum OrchidRoutes: string
{
    case ARTICLES = 'article';
    case ARTICLE_CATEGORIES = 'article-category';
    case SEO = 'seo';
    case RACES = 'race';
    case GENDER = 'gender';
    case ORIGIN = 'origin';
    case CHCLASS = 'class';
    case ROBOTS = 'robot';
    case SITEMAP = 'sitemap';
    case INFO_PAGES = 'pages';
    case CONFIGURATOR = 'configurator';

    public function list(): string
    {
        return 'platform.' . $this->value . '.list';
    }

    public function create(): string
    {
        return 'platform.' . $this->value . '.create';
    }

    public function edit(): string
    {
        return 'platform.' . $this->value . '.edit';
    }

    public function base()
    {
        return 'platform.' . $this->value;
    }

    /**
     * @throws Exception
     */
    public function getTitle(): string
    {
        return match ($this->value) {
            self::ARTICLES->value => 'Публикации',
            self::ARTICLE_CATEGORIES->value => 'Категории публикаций',
            self::INFO_PAGES->value => 'Страницы',
            self::SEO->value => 'SEO-модуль',
            self::CHCLASS->value => 'Классы',
            self::ORIGIN->value => 'Происхождение',
            self::GENDER->value => 'Гендер',
            self::RACES->value => 'Расы',
            self::CONFIGURATOR->value => 'Конфигуратор',
            self::ROBOTS->value => 'Robots.txt',
            self::SITEMAP->value => 'Карта сайта',
            default => throw new Exception('Unexpected match value'),
        };
    }

    /**
     * @throws Exception
     */
    public function isSingle(): bool
    {
        return match ($this->value) {
            self::ARTICLES->value,
            self::ARTICLE_CATEGORIES->value,
            self::RACES->value => false,
            self::GENDER->value,
            self::CHCLASS->value,
            self::ORIGIN->value,
            self::INFO_PAGES->value,
            self::SEO->value => false,
            self::CONFIGURATOR->value,
            self::SITEMAP->value,
            self::ROBOTS->value => true,
            default => throw new Exception('Unexpected match value'),
        };
    }
}
