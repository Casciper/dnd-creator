<?php

namespace App\Orchid\Layouts\Pages;

use App\Orchid\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;

class LinkLayout extends AbstractPageLayout
{
    public function fields(): iterable
    {
        $layout = [
            Group::make([
                Input::make('item.title')->title('Заголовок на странице')->help('Заголовок, который будет выводиться на странице'),
                Cropper::make('item.image_outer')->targetRelativeUrl()->title('Изображение в списке'),
            ]),
        ];

        return array_merge(parent::getDefaultLayout(), $layout);
    }

    public function setValidationRules():void
    {
        $this->validationRules = [];
    }

    public function setValidationMessages(): void
    {
        $this->validationMessages = [];
    }
}
