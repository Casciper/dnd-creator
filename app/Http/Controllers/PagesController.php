<?php

namespace App\Http\Controllers;

use App\Enums\PagesTypes;
use App\Models\Page;

class PagesController extends Controller
{
    public function getPage(?string $params)
    {
        $page = Page::query()->active()->with(['children'])->where('uri', '/' . $params)->first();
        abort_if(!$page, 404);

        $view = 'modules.pages.default';
        if ($type = PagesTypes::from($page->type)) {
            $view = $type->getTemplate();
        }

        $page->setBreadCrumbs();

        if ($page->parent_id) {
            abort_if(!$page->parent, 404);
            $page = Page::query()->where('parent_id', $page->parent->id)->with('children')->first();
        }

        return view($view, compact('page'));
    }
}
