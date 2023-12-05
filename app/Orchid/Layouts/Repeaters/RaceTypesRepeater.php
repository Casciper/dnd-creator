<?php

namespace App\Orchid\Layouts\Repeaters;

use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class RaceTypesRepeater extends Rows
{
    function fields(): array
    {
        return [
            Input::make('name')->title('Название')->required(),
            Input::make('code')->title('Код')->required(),
            TextArea::make('description')->title('Описание')->required(),
            Group::make([
                Input::make('stats.strength')->title('Сила')->type('number'),
                Input::make('stats.dexterity')->title('Ловкость')->type('number'),
                Input::make('stats.constitution')->title('Телосложение')->type('number'),
                Input::make('stats.intelligence')->title('Интеллект')->type('number'),
                Input::make('stats.wisdom')->title('Мудрость')->type('number'),
                Input::make('stats.charisma')->title('Харизма')->type('number'),
            ])
        ];
    }
}
