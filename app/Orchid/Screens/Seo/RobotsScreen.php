<?php

namespace App\Orchid\Screens\Seo;

use App\Enums\OrchidRoutes;
use App\Orchid\Abstractions\EditScreenPattern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Code;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class RobotsScreen extends EditScreenPattern
{
    protected string $file = '/robots.txt';

    public function __construct()
    {
        $this->route = OrchidRoutes::ROBOTS;
        $this->redirectTo = $this->route->base();
    }

    public function commandBar()
    {
        return [
            Button::make(__('orchid.save'))->icon('save')->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Code::make('robots')->language(Code::MARKUP)->height('1000px'),
            ]),
        ];
    }

    public function query()
    {
        $this->name = 'Редактирование файла robots.txt';
        $fileContent = Storage::disk('public')->get($this->file);

        return [
            'robots' => $fileContent ?? '',
        ];
    }

    public function save(Request $request)
    {
        $data = $request->input('robots');
        Storage::disk('public')->put($this->file, $data);
        Alert::success('Файл robots.txt успешно обновлён');
    }
}
