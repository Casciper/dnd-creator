<?php

namespace App\Orchid\Screens\Articles;

use App\Enums\OrchidRoutes;
use App\Models\ArticleCategory;
use App\Orchid\Abstractions\EditScreenPattern;
use App\Orchid\Helpers\OrchidValidator;
use App\Orchid\Screens\Modals\EmptyModal;
use App\Orchid\Traits\CommandBarDeletableTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ArticleCategoryEdit extends EditScreenPattern
{
    protected string $createTitle = 'Создание категории статей';
    protected string $updateTitle = 'Редактирование категории статей';
    protected string $deleteMessage = 'Запись успешно удалена';
    protected string $createMessage = 'Запись успешно добавлена';
    protected string $titleColumnName = 'title';

    use CommandBarDeletableTrait;

    public function __construct()
    {
        $this->route = OrchidRoutes::ARTICLE_CATEGORIES;
        $this->routeName = $this->route->list();
    }

    public function query(ArticleCategory $item): array
    {
        return $this->queryMake($item);
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                CheckBox::make('item.is_active')->title('Активность')->sendTrueOrFalse()->value(true),
                Input::make('item.sort')->title('Порядок Сортировки')->type('number')->value(0),
                Input::make('item.title')->title('Название')->required()->maxlength(169)->help('Не более 169 символов'),
                Input::make('item.code')->title('Код')->required()->help('Не более 30 символов'),
                TextArea::make('item.description')->title('Описание')->rows(5),
            ]),
            Layout::modal('deleteItem', EmptyModal::class)->title('Уверены, что хотите удалить запись?')
                ->applyButton('Да')->closeButton('Нет'),
        ];
    }

    public function save(ArticleCategory $item, Request $request)
    {
        $data = $request->input('item');
        $data['code'] = Str::slug($data['code']);
        $data['sort'] = $data['sort'] ?? 0;
        $data['id'] = $item->id;

        $validator = (new OrchidValidator($data, ['title', 'sort']))->setIndividualRules($this->getRules(), $this->getMessages())
            ->setUniqueFields($item, ['code' => 'Такой код уже используется'])
            ->validate();

        return $validator->isFail() ? $validator->showErrors($this->route, $item->id) : $this->saveItem($item, $data);
    }

    public function remove(ArticleCategory $item): RedirectResponse
    {
        if ($item->articles()->count() !== 0) {
            Alert::error('Эта категория не является пустой. Её нельзя удалить');
            return redirect()->route($this->route->edit(), ['item' => $item->id]);
        }

        return $this->removeItem($item);
    }

    public function getRules(): array
    {
        return [
            'code' => ['bail', 'required', 'max:160'],
            'description' => ['bail', 'nullable', 'max:1024'],
            'seo_title' => ['bail', 'nullable', 'max:169'],
            'seo_description' => ['bail', 'nullable'],
        ];
    }

    public function getMessages(): array
    {
        return [
            'code.required' => 'Введите код категории',
            'code.max' => 'Заголовок не может быть длиннее 160 символов',
            'description.required' => 'Введите описание категории',
            'description.max' => 'Описание не может быть длиннее 160 символов',
            'seo_title.required' => 'Введите SEO заголовок',
            'seo_description.required' => 'Введите SEO описание',
        ];
    }
}
