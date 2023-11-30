<?php

namespace App\Orchid\Layouts\Pages;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;

class AboutCompanyPageLayout extends AbstractPageLayout
{
    function fields(): iterable
    {
        $layout = [
            Group::make([
                Input::make('item.data.title')->title('Заголовок')->required(),
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

