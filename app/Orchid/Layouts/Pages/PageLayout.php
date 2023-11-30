<?php

namespace App\Orchid\Layouts\Pages;

use App\Orchid\Fields\Cropper;
use App\Orchid\Fields\TinyMce;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;

class PageLayout extends AbstractPageLayout
{
    public function fields(): iterable
    {
        $layout = [
            Group::make([
                Input::make('item.title')->title('Заголовок на странице')->help('Заголовок, который будет выводиться на странице'),
            ]),
            Group::make([
                Cropper::make('item.image_outer')->targetRelativeUrl()->title('Изображение в списке'),
                Cropper::make('item.image_inner')->targetRelativeUrl()->title('Изображение в карточке'),
            ]),
            TinyMce::make('item.text')->title('Текст'),
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
