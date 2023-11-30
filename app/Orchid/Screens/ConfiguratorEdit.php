<?php

namespace App\Orchid\Screens;

use App\Enums\OrchidRoutes;
use App\Models\Configurator;
use App\Orchid\Abstractions\EditScreenPattern;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ConfiguratorEdit extends EditScreenPattern
{
    public string $name = 'Конфигуратор';
    protected string $createTitle = 'Создание конфигурации';
    protected string $updateTitle = 'Редактирование конфигурации';
    protected array $fields = [];

    public function __construct()
    {
        $this->route = OrchidRoutes::CONFIGURATOR;
        $this->redirectTo = $this->route->base();
    }

    public function commandBar()
    {
        return [
            Button::make(__('orchid.save'))->icon('note')->method('save'),
        ];
    }

    public function layout(): array
    {
        $inputs = [];
        foreach ($this->fields as $key => $field) {
            $inputs[] = Input::make('item.' . $key)->title($field['title'])->required();
        }
        return [
            Layout::rows($inputs),
        ];
    }

    public function query()
    {
        $confRows = CommonRepository::take()->getConfigurationData();
        $item = [];

        foreach ($confRows as $row) {
            $item[$row['key']] = $row['value'];
            $this->fields[$row['key']]['value'] = $row['value'];
            $this->fields[$row['key']]['title'] = $row['title'];
            $this->fields[$row['key']]['key'] = $row['key'];
        }

        return [
            'item' => $item
        ];
    }

    public function save(Configurator $item, Request $request)
    {
        $data = $request->input('item');
        $result = CommonRepository::take()->updateConfigurationData($data);

        if ($result) {
            Alert::success('Данные успешно обновлены');
        } else {
            Alert::error('Произошла ошибка при попытке обновления данных');
        }
    }

    public function remove(Configurator $item)
    {
        return $this->removeItem($item);
    }
}
