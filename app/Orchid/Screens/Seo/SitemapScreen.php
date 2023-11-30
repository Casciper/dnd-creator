<?php

namespace App\Orchid\Screens\Seo;

use App\Enums\OrchidRoutes;
use App\Orchid\Abstractions\EditScreenPattern;
use App\Services\SitemapGenerator;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Code;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SitemapScreen extends EditScreenPattern
{
    public function __construct()
    {
        $this->route = OrchidRoutes::SITEMAP;
        $this->redirectTo = $this->route->base();
    }

    public function commandBar(): array
    {
        return [
            Button::make('Обновить')->icon('refresh')->method('generateXml'),
        ];
    }

    public function generateXml()
    {
        $generator = new SitemapGenerator();
        $mapContent = $generator->generateMap();
        Storage::disk('public')->put('/sitemap.xml', $mapContent);
        Alert::success('Карта сайта успешно обновлена!');
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Code::make('xml')->language(Code::MARKUP)->readonly()->height('1000px'),
            ]),
            Layout::modal('generateXml', Layout::rows([]))->title('Обновление sitemap может быть нагруженной операцией. Не выполняйте её без необходимости')
                ->applyButton('Выполнить обновление')->closeButton('Отменить'),
        ];
    }

    public function query()
    {
        $this->name = 'Карта сайта';
        $xml = Storage::disk('public')->get('/sitemap.xml') ?? '';

        return [
            'xml' => $xml,
        ];
    }
}
