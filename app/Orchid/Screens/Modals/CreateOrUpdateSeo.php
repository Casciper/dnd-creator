<?php

namespace App\Orchid\Screens\Modals;

use App\Orchid\Fields\TinyMce;
use Orchid\Screen\Fields\CheckBox;
use App\Orchid\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

class CreateOrUpdateSeo
{
    public static function getModal(): Rows
    {
        return Layout::rows([
            CheckBox::make('item.indexation_off')->title('Закрыть страницу от индексации')->sendTrueOrFalse()->value(false),
            Input::make('item.url')->title('URL')->required(),
            Input::make('item.title')->title('Title ')->required()->maxlength(220)->help('Не более 220 символов'),
            Input::make('item.seo_title')->title('Seo-Заголовок ')->maxlength(220)->help('Не более 220 символов'),
            TextArea::make('item.description')->title('Description ')->rows(5),
            TinyMce::make('item.text')->title('Seo-текст'),
            Cropper::make('item.image')->title('Изображение для страницы')->width(650)->height(650)->targetRelativeUrl(),
        ]);
    }
}
