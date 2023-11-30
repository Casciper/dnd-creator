<?php

namespace App\Orchid\Screens\Articles;

use App\Enums\OrchidRoutes;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Orchid\Abstractions\EditScreenPattern;
use App\Orchid\Fields\Cropper;
use App\Orchid\Fields\TinyMce;
use App\Orchid\Helpers\OrchidValidator;
use App\Orchid\Screens\Modals\EmptyModal;
use App\Orchid\Traits\CommandBarDeletableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;

class ArticleEdit extends EditScreenPattern
{
    protected string $createTitle = 'Создание статьи';
    protected string $updateTitle = 'Редактирование статьи';
    protected string $deleteMessage = 'Запись успешно удалена';
    protected string $createMessage = 'Запись успешно добавлена';
    protected string $titleColumnName = 'title';

    use CommandBarDeletableTrait;

    public function __construct()
    {
        $this->route = OrchidRoutes::ARTICLES;
        $this->routeName = $this->route->edit();
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Group::make([
                        CheckBox::make('item.is_active')->title('Активность')->sendTrueOrFalse()->value(true),
                        Label::make('item.slug')->title('Код')->popover('Генерируется автоматически на основе заголовка'),
                    ]),
                    Input::make('item.title')->title('Заголовок')->required()->maxlength(120)->help('Не более 120 символов'),
                    TextArea::make('item.description')->title('Анонс')->rows(5)->maxlength(1024)->required(),
                    Cropper::make('item.image_outer')->title('Изображение для страницы')->targetRelativeUrl()->help('Загрузка изображения обязательна')->required(),
                ]),
                Layout::rows([
                    Select::make('item.category_id')->title('Категория')->empty('Категория не выбрана')
                        ->fromQuery(ArticleCategory::query()->active()->sorted(), 'title', 'id')->required(),
                    DateTimer::make('item.publication_date')->title('Дата публикации')->format24hr()->required()->value(Carbon::today()),
                    TinyMce::make('item.text')->title('Текст публикации')->required(),
                    Cropper::make('item.image_inner')->title('Изображение для списка')->targetRelativeUrl()->help('Загрузка изображения обязательна')->required(),
                ]),
            ]),
            Layout::modal('deleteItem', EmptyModal::class)->title('Уверены, что хотите удалить запись?')
                ->applyButton('Да')->closeButton('Нет'),
        ];
    }

    public function query(Article $item)
    {
        return $this->queryMake($item);
    }

    public function save(Article $item, Request $request)
    {
        $data = $request->input('item');

        $validator = (new OrchidValidator($data, []))->setIndividualRules($this->getRules(), $this->getMessages())
            ->clearQuillTags(['text'])
            ->validate();

        if ($item->exists) {
            $data['slug'] = $item->getIdentifier();
        } else {
            $data['slug'] = Str::slug($data['title']);
            $item->fill($data)->save();
            $data['slug'] = Str::slug($item->id . '-' . $data['title']);
        }

        return $validator->isFail() ? $validator->showErrors($this->route, $item->id) : $this->saveItem($item, $data);
    }

    public function remove(Article $item)
    {
        return $this->removeItem($item);
    }

    public function getRules(): array
    {
        return [
            'title' => ['bail', 'required', 'max:120'],
            'category_id' => ['bail', 'required',],
            'description' => ['bail', 'required', 'max:1024'],
            'text' => ['bail', 'required',],
            'publication_date' => ['bail', 'required',],
            'seo_description' => ['bail', 'nullable', 'max:1024'],
        ];
    }

    public function getMessages(): array
    {
        return [
            'title.required' => 'Введите заголовок статьи',
            'title.max' => 'Заголовок статьи не может быть длиннее 120 символов',
            'category_id.required' => 'Выберите категорию статьи',
            'description.required' => 'Введите анонс статьи',
            'description.max' => 'Анонс не может быть длиннее 1024 символов',
            'text.required' => 'Введите текст статьи',
            'publication_date.required' => 'Выберите дату публикации',
            'seo_description.max' => 'SEO Description не может быть длиннее 1024 символов',
        ];
    }
}
