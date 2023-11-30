<?php

namespace App\Orchid\Screens\Races;

use App\Enums\OrchidRoutes;
use App\Models\chClass;
use App\Models\Gender;
use App\Models\Race;
use App\Orchid\Abstractions\EditScreenPattern;
use App\Orchid\Fields\TinyMce;
use App\Orchid\Helpers\OrchidValidator;
use App\Orchid\Layouts\Repeaters\RaceTypesRepeater;
use App\Orchid\Screens\Modals\EmptyModal;
use App\Orchid\Traits\CommandBarDeletableTrait;
use Illuminate\Http\Request;
use Nakukryskin\OrchidRepeaterField\Fields\Repeater;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;

class RaceEdit extends EditScreenPattern
{
    protected string $createTitle = 'Создание расы';
    protected string $updateTitle = 'Редактирование расы';
    protected string $deleteMessage = 'Раса успешно удалена';
    protected string $createMessage = 'Раса успешно добавлена';
    protected string $titleColumnName = 'name';
    protected array $relations = ['genders', 'chClasses'];

    use CommandBarDeletableTrait;

    public function __construct()
    {
        $this->route = OrchidRoutes::RACES;
        $this->routeName = $this->route->edit();
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Group::make([
                        CheckBox::make('item.is_active')->title('Активность')->sendTrueOrFalse()->value(true),
                        Input::make('item.name')->title('Название')->required(),
                        Input::make('item.code')->title('Код')->required(),
                    ]),

                    Group::make([
                       Select::make('item.genders')->title('Гендеры')->required()
                           ->fromQuery(Gender::query()->active(), 'name', 'id')->multiple(),
                        Select::make('item.chClasses')->title('Классы')->required()
                            ->fromQuery(chClass::query()->active(), 'name', 'id')->multiple(),
                    ]),

                    Group::make([
                        Input::make('item.type')->title('Вид существа'),
                        Input::make('item.size')->title('Размер'),
                        Input::make('item.speed')->title('Скорость')->type('number'),
                    ]),

                    Group::make([
                        Input::make('item.data.stats.strength')->title('Сила')->type('number'),
                        Input::make('item.data.stats.dexterity')->title('Ловкость')->type('number'),
                        Input::make('item.data.stats.constitution')->title('Телосложение')->type('number'),
                        Input::make('item.data.stats.intelligence')->title('Интеллект')->type('number'),
                        Input::make('item.data.stats.wisdom')->title('Мудрость')->type('number'),
                        Input::make('item.data.stats.charisma')->title('Харизма')->type('number'),
                    ]),

                    TinyMce::make('item.description')->title('Описание расы')->required(),
                    Repeater::make('item.data.race_types')->title('Типы расы')->layout(RaceTypesRepeater::class),
                ]),
            ]),
            Layout::modal('deleteItem', EmptyModal::class)->title('Уверены, что хотите удалить запись?')
                ->applyButton('Да')->closeButton('Нет'),
        ];
    }

    public function query(Race $item)
    {
        return $this->queryMake($item);
    }

    public function save(Race $item, Request $request)
    {
        $data = $request->input('item');

        $validator = (new OrchidValidator($data, []))->setIndividualRules($this->getRules(), $this->getMessages())
            ->validate();

        return $validator->isFail() ? $validator->showErrors($this->route, $item->id) : $this->saveItem($item, $data);
    }

    public function remove(Race $item)
    {
        return $this->removeItem($item);
    }

    public function getRules(): array
    {
        return [];
    }

    public function getMessages(): array
    {
        return [];
    }
}
