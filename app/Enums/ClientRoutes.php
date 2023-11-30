<?php

namespace App\Enums;

use Exception;

enum ClientRoutes: string
{
    case MAIN_PAGE = 'web.main.page';
    case BLOG_LIST = 'web.articles.list';
    case BLOG_LIST_PAGE = 'web.articles.list.page';
    case BLOG_CATEGORY = 'web.articles.category';
    case BLOG_CATEGORY_PAGE = 'web.articles.category.page';
    case BLOG_ARTICLE = 'web.articles.card';
    case PAGES = 'web.pages.page';

}
