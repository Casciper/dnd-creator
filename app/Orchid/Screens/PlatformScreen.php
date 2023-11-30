<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    public function query(): iterable
    {
        return [];
    }

    public function name(): ?string
    {
        return 'Панель администратора';
    }

    public function description(): ?string
    {
        return 'Это стартовый экран панели администратора';
    }

    public function layout(): iterable
    {
        return [
            Layout::view('admin.welcome'),
        ];
    }
}
