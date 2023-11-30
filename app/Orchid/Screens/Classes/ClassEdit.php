<?php

namespace App\Orchid\Screens\Classes;

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
use Orchid\Support\Facades\Layout;

class ClassEdit extends EditScreenPattern
{
    protected string $createTitle = 'Создание класса';
    protected string $updateTitle = 'Редактирование класса';
    protected string $deleteMessage = 'Класс успешно удален';
    protected string $createMessage = 'Класс успешно добавлен';
    protected string $titleColumnName = 'name';

    use CommandBarDeletableTrait;

    public function __construct()
    {
        $this->route = OrchidRoutes::CHCLASS;
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
                ]),
            ]),
            Layout::modal('deleteItem', EmptyModal::class)->title('Уверены, что хотите удалить запись?')
                ->applyButton('Да')->closeButton('Нет'),
        ];
    }

    public function query(chClass $item)
    {
        return $this->queryMake($item);
    }

    public function save(chClass $item, Request $request)
    {
        $data = $request->input('item');

        $validator = (new OrchidValidator($data, []))->setIndividualRules($this->getRules(), $this->getMessages())
            ->validate();

        return $validator->isFail() ? $validator->showErrors($this->route, $item->id) : $this->saveItem($item, $data);
    }

    public function remove(chClass $item)
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
