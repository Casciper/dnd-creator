<?php

namespace App\Orchid\Screens\Genders;

use App\Enums\OrchidRoutes;
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

class GenderEdit extends EditScreenPattern
{
    protected string $createTitle = 'Создание гендера';
    protected string $updateTitle = 'Редактирование гендера';
    protected string $deleteMessage = 'Гендер успешно удален';
    protected string $createMessage = 'Гендер успешно добавлен';
    protected string $titleColumnName = 'name';

    use CommandBarDeletableTrait;

    public function __construct()
    {
        $this->route = OrchidRoutes::GENDER;
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

    public function query(Gender $item)
    {
        return $this->queryMake($item);
    }

    public function save(Gender $item, Request $request)
    {
        $data = $request->input('item');

        $validator = (new OrchidValidator($data, []))->setIndividualRules($this->getRules(), $this->getMessages())
            ->validate();

        return $validator->isFail() ? $validator->showErrors($this->route, $item->id) : $this->saveItem($item, $data);
    }

    public function remove(Gender $item)
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
