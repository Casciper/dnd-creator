<?php

namespace App\Http\Controllers;

use App\Enums\ClientRoutes;
use App\Helpers\CommonHelper;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Services\ArticlesService;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    /**
     * Страница со списком категорий и статей
     * @route /articles
     * @method GET
     * @param ArticlesService $articlesService
     * @param int|null $page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getArticlesList(ArticlesService $articlesService, ?int $page = null)
    {
        $page = $page ?: 1;

        $categories = $articlesService->getCategoriesWithCurrent();
        $articles = $articlesService->getArticlesList($page);
        $paginator = $articles->linkCollection()->paginizate();

        $crumbs = [
            [
                'title' => 'Блог',
                'route' => 'web.blog.list'
            ],
        ];

        if ($page > 1) {
            $crumbs[] = [
                'title' => 'Страница ' . $page,
                'route' => 'web.blog.list.page',
                'params' => [$page]
            ];
        }

        CommonHelper::setCrumbs($crumbs);

        return view('modules.blog.list', compact('articles', 'categories', 'paginator', 'page'));
    }

    /**
     * Страница со статьями из выбранной категории
     * @route /articles/{categoryCode}
     * @method GET
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getArticlesCategory(ArticlesService $articlesService, string $categoryCode, ?int $page = null)
    {
        $page = $page ?: 1;

        $currentCategory = ArticleCategory::query()->active()->code($categoryCode)->firstOrFail();

        $categories = $articlesService->getCategoriesWithCurrent($currentCategory);

        $articles = $articlesService->getArticlesList($page, $categoryCode);

        abort_if($articles->isEmpty(), 404);
        $paginator = $articles->linkCollection()->paginizate();

        $crumbs = [
            [
                'title' => 'Блог',
                'route' => 'web.blog.list',
            ],
            [
                'title' => $currentCategory->getTitle(),
                'route' => 'web.blog.category',
                'params' => [$currentCategory->code]
            ]
        ];

        if ($page > 1) {
            $crumbs[] = [
                'title' => 'Страница ' . $page,
                'route' => 'web.blog.category.page',
                'params' => [$currentCategory->code, $page]
            ];
        }

        CommonHelper::setCrumbs($crumbs);

        return view('modules.blog.list', compact('articles', 'categories', 'currentCategory', 'paginator', 'page'));
    }

    /**
     * Подробная страница конкретной статьи
     * @route /articles/{categoryCode}/{articleCode}
     * @method GET
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getArticlePage(ArticlesService $articlesService, string $categoryCode, string $articleSlug)
    {
        $article = Article::query()->with('category')->active()->publicated()->where('slug', '=', $articleSlug)
            ->whereHas('category', fn($q) => $q->active()->code($categoryCode))->firstOrFail();

        $otherArticles = Article::query()->whereHas('category', fn($q) => $q->active()->code($categoryCode))
            ->active()->publicated()->publicationSorted()->where('slug', '!=', $articleSlug)
            ->with('category')->limit(4)->get();

        $crumbs = [
            [
                'title' => 'Блог',
                'route' => 'web.blog.list',
            ],
            [
                'title' => $article->category->getTitle(),
                'route' => 'web.blog.category',
                'params' => [$categoryCode]
            ],
            [
                'title' => $article->getTitle(),
                'route' => 'web.blog.card',
                'params' => [$categoryCode, $articleSlug]
            ]
        ];

        CommonHelper::setCrumbs($crumbs);

        return view('modules.blog.item', compact('article', 'otherArticles'));
    }
}
