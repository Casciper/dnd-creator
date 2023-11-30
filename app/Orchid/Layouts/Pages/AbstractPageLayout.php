<?php

namespace App\Orchid\Layouts\Pages;

use App\Enums\PagesTypes;
use App\Helpers\Constants;
use App\Models\Page;
use App\Orchid\Fields\Divider;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

abstract class AbstractPageLayout extends Rows
{
    protected array $validationRules = [];
    protected array $validationMessages = [];

    public function __construct()
    {
        $this->setValidationRules();
        $this->setValidationMessages();
    }

    public function getDefaultLayout(): array
    {
        $item = $this->query->all()['item'];
        return [
            Divider::make('item.heading')->value('Основная информация')->class('mb-20'),
            Group::make([
                CheckBox::make('item.is_active')->title('Активность')->sendTrueOrFalse(),
                Label::make('item.page_type')->title('Тип страницы')->value(PagesTypes::from($item->type)->getTitle())->style('margin-bottom:0'),
                Input::make('item.code')->title('Код страницы')->help('Участвует в построении URL-адреса страницы'),
                Select::make('item.parent_id')->title('Родитель')
                    ->empty('Выберите родителя')
                    ->fromQuery(Page::query()->where('id', '!=', $item->id), 'name', 'id'),

            ]),
            Group::make([
                Input::make('item.name')->title('Название страницы')->help('Название страницы, которое будет отображаться на разводящей странице и участвовать в построении хлебных крошек'),
                Input::make('item.sort')->title('Порядок сортировки')->type('number')->value(0),
            ]),
            Group::make([
                TextArea::make('item.announce')->title('Анонс')->rows(5)->help('Анонс, который выводится в описание карточки в списке элементов'),
                Input::make('item.uri')->title('URI')->required()
            ]),
            Divider::make('item.heading')->value('Информация о странице')->class('mtb-20'),
        ];
    }

    public function getRules(): array
    {
        $defaultValidationRules = [
            'code' => ['bail', 'required', 'max:55', Constants::REGEX_CODE_RULE],
            'name' => ['bail', 'required',]
        ];
        return array_merge($this->validationRules, $defaultValidationRules);
    }

    public function getMessages(): array
    {
        $defaultValidationMessages = [
            'code.required' => 'Укажите код страницы',
            'code.max' => 'Максимальная длинна кода не выше 55 символов',
            'code.regex' => 'Код может содержать только латинские символы',
            'name.required' => 'Укажите название страницы',
        ];
        return array_merge($this->validationMessages, $defaultValidationMessages);
    }

    abstract function setValidationRules(): void;

    abstract function setValidationMessages(): void;


}

