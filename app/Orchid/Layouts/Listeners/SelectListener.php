<?php

namespace App\Orchid\Layouts\Listeners;

use App\Enums\PagesTypes;
use App\Models\Page;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;

class SelectListener extends Listener
{
    protected $targets = [
        'item.type',
    ];

    protected $asyncMethod = 'asyncType';

    protected function layouts(): array
    {
        return [
            Layout::rows([
                Input::make('item.name')
                    ->type('text')
                    ->max(255)
                    ->required()
                    ->title('Название')
                    ->placeholder('Название'),

                Input::make('item.code')
                    ->type('text')
                    ->required()
                    ->title('Код')
                    ->placeholder('Код'),

                Select::make('item.type')
                    ->title('Тип страницы')
                    ->empty('Выберите тип')
                    ->required()
                    ->options([
                        'link' => 'Ссылка',
                        'page' => 'Страница',
                        'template' => 'Шаблон'
                    ]),

                Select::make('item.template')
                    ->title('Выбор шаблона')
                    ->options(PagesTypes::getOptions())
                    ->canSee($this->query->get('item.type') === 'template'),

                Select::make('item.parent_id')
                    ->title('Родительская страница')
                    ->empty('Выберите родителя')
                    ->fromQuery(Page::query(), 'name', 'id'),
            ])
        ];
    }

    public function handle(Repository $repository, Request $request): Repository
    {
        $data = $request->input('item');

        return $repository
            ->set('item.name', $data['name'])
            ->set('item.code', $data['code'])
            ->set('item.type', $data['type'])
            ->set('item.parent_id', $data['parent_id']);
    }
}
