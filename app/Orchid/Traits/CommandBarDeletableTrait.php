<?php

    namespace App\Orchid\Traits;

    use Orchid\Screen\Actions\Button;
    use Orchid\Screen\Actions\Link;
    use Orchid\Screen\Actions\ModalToggle;

    trait CommandBarDeletableTrait
    {
        public function commandBar(): array
        {
            return [
                Link::make(__('Назад'))->icon('arrow-left-circle')
                    ->route($this->route->list(), $this->redirectParams),

                Button::make('Сохранить')->icon('note')->method('save'),

                ModalToggle::make('Удалить')->icon('trash')->modal('deleteItem')
                    ->method('remove')->canSee($this->exists),
            ];
        }
    }
