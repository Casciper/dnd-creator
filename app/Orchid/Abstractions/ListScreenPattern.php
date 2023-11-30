<?php

namespace App\Orchid\Abstractions;

use App\Enums\OrchidRoutes;
use App\Models\ProtoModel;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use function session;

abstract class ListScreenPattern extends Screen
{
    /** Модель, используемая для получения данных
     * @var Builder
     */
    protected Builder $model;

    /** Количество экземпляров модели, выводимое на страницу
     * @var int
     */
    protected int $paginate = 20;

    /** Параметры для редиректа к списку моделей (номер страницы)
     * @var array
     */
    protected array $redirectParams = [];

    /** Enum в котором хранятся данные по именам роутов для админки
     * @var OrchidRoutes
     */
    protected OrchidRoutes $route;

    /** Список отношений для синхронизации с текущей моделью
     * @var array
     */
    protected array $relations = [];

    public function query(): iterable
    {
        $items = $this->model->paginate($this->paginate);
        $this->redirectParams = ['page' => $items->currentPage()];
        $this->setRedirect();

        return [
            'items' => $items,
        ];
    }

    protected function setRedirect(string $uri = null): void
    {
        session()->put('listRedirect', $this->route->edit());
        session()->put('redirectParams', $this->redirectParams);
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить запись')->icon('plus')->route($this->route->create()),
        ];
    }

    public function detachRelations(ProtoModel $item)
    {
        if (!empty($this->relations)) {
            foreach ($this->relations as $relation) {
                $item->$relation()->detach();
            }
        }
    }
}
