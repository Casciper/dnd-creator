<?php

namespace App\Orchid\Screens\Modals;

use Orchid\Screen\Layouts\Rows;

class EmptyModal extends Rows
{
    protected function fields(): iterable
    {
        return [];
    }
}
