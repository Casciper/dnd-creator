<?php

namespace App\Orchid\Screens\Articles;

use App\Enums\OrchidRoutes;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Orchid\Abstractions\ListScreenPattern;
use App\Orchid\Filters\DateCreatedFilter;
use App\Orchid\Filters\IsActiveFilter;
use App\Orchid\Helpers\OrchidHelper;
use App\Orchid\Traits\ActivitySignsTrait;
use Lintaba\OrchidTables\Screen\TDChecklist;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ArticleCategoryList extends ListScreenPattern
{
    use ActivitySignsTrait;

    public function __construct()
    {
        $this->route = OrchidRoutes::ARTICLE_CATEGORIES;
        $this->name = $this->route->getTitle();
    }

    public function query(): iterable
    {
        $this->model = ArticleCategory::query()->filters();
        return parent::query();
    }

    public function layout(): iterable
    {
        return [
            Layout::table('items', [
                TD::make('id', 'ID'),
                TD::make('is_active', 'Активность')->sort()->filter(
                    Select::make()->options(OrchidHelper::getYesNoArray())->empty()->title('Фильтр активности')
                )->render(fn($item) => $item->is_active ? $this->activeSign : $this->inactiveSign),
                TD::make('sort', 'Сортировка')->sort()->filter(),
                TD::make('title', 'Название')->sort()->filter(),
                TD::make('code', 'Код')->sort()->filter(),

                TD::make('created_at', 'Дата')->alignRight()->sort()
                    ->filter(DateTimer::make()->title('Фильтр по дате')->format('d-m-Y'))
                    ->render(fn($item) => $item->created_at?->format('d.m.Y')),

                TD::make()->width(10)->alignRight()->cantHide()
                    ->render(fn($item) =>
                    DropDown::make()->icon('options-vertical')->list([
                        Link::make(__('Edit'))->icon('wrench')->route(OrchidRoutes::ARTICLE_CATEGORIES->edit(), $item),
                        Button::make('Удалить')->icon('trash')
                            ->method('deleteItem', ['item' => $item->id, 'title' => $item->getTitle()])
                            ->confirm('Вы действительно хотите удалить запись №' . $item->id . ' - <strong>' . $item->getTitle() . '</strong>?'),
                    ])),
            ]),
        ];
    }

    public function deleteItem(ArticleCategory $item)
    {
        $id = $item->id;
        $title = $item->getTitle();
        $item->delete() ? Alert::success("Запись №:$id - '$title'  успешно удалена!")
            : Alert::error("Произошла ошибка при попытке удалить запись");
    }
}
