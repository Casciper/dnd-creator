<?php

namespace App\Orchid\Screens\Genders;

use App\Enums\OrchidRoutes;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Gender;
use App\Models\Race;
use App\Orchid\Abstractions\ListScreenPattern;
use App\Orchid\Helpers\OrchidHelper;
use App\Orchid\Traits\ActivitySignsTrait;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class GenderList extends ListScreenPattern
{
    use  ActivitySignsTrait;

    public function __construct()
    {
        $this->route = OrchidRoutes::GENDER;
        $this->name = $this->route->getTitle();
    }

    public function query(): iterable
    {
        $this->model = Gender::query()->filters();
        return parent::query();
    }

    public function layout(): iterable
    {
        return [
            Layout::table('items', [
                TD::make('id', 'ID'),
                TD::make('is_active', 'Активность')->sort()->filter(
                    Select::make()->options(OrchidHelper::getYesNoArray())->empty()->title('Фильтр активности')
                )->render(fn($item) => $this->isActive($item)),
                TD::make('name', 'Название')->sort()->filter()->render(fn ($item) => Str::limit($item->name, 35)),
                TD::make('code', 'Код')->sort()->filter()->render(fn ($item) => Str::limit($item->code, 35)),

                TD::make()->width(10)->alignRight()->cantHide()
                    ->render(fn($item) =>
                    DropDown::make()->icon('options-vertical')->list([
                        Link::make('Редактировать')->icon('wrench')->route(OrchidRoutes::GENDER->edit(), $item),
                        Button::make('Удалить')->icon('trash')
                            ->method('deleteItem', ['item' => $item->id, 'title' => $item->getTitle()])
                            ->confirm('Что хотите удалить запись №:' . $item->id . ' - ' . $item->getTitle() . '?'),
                ])),
            ]),
        ];
    }

    public function deleteItem(Gender $item)
    {
        $id = $item->id;
        $title = $item->getTitle();
        $item->delete() ? Alert::success("Запись №:$id - '$title'  успешно удалена!")
            : Alert::error("Произошла ошибка при попытке удалить запись");
    }
}
