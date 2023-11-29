<?php

namespace App\Http\Middleware;

use App\Helpers\Constants;
use App\Models\InformationPage;
use App\Models\Page;
use App\Models\Seo;
use App\Repositories\CatalogRepository;
use App\Services\PagesService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Pages
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $page = Page::query()->active()->with(['children', 'parent', 'parentRecursive'])->where('uri', '/' . $request->path())->first();

        $data = [
            'page' => $page
        ];

        if (!is_null($page) && $page->parent_id) {
            $lastParentPage = (new PagesService())->getLastParent($page);
            $menuTitle = $lastParentPage->name;
            $menu = Page::query()->active()->where('parent_id', $lastParentPage->id)->get()->each(
                function ($item) use ($page) {
                    $item->active_menu = $item->uri === $page->uri;
                });

            $data = array_merge($data, [
                'lastParentPage' => $lastParentPage,
                'menuTitle' => $menuTitle,
                'menu' => $menu,
            ]);
        }

        View::composer('*', function (\Illuminate\View\View $view) use ($data) {
            $view->with($data);
        });

        return $next($request);
    }
}
