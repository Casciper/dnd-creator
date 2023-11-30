<?php

namespace App\Orchid\Layouts\Repeaters;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class RaceTypesRepeater extends Rows
{
    function fields(): array
    {
        return [
            Input::make('name')->title('Название')->required(),
            TextArea::make('description')->title('Описание')->required()
        ];
    }
}
