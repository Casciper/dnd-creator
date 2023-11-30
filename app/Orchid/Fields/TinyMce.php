<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

class TinyMce extends Field
{
    protected $view = "admin.fields.tinymce";

    /**
     * All attributes that are available to the field.
     *
     * @var array
     */
    protected $attributes = [
        'value'  => null,
        'height' => '300px',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'name',
        'disabled',
        'placeholder',
        'readonly',
        'required' => 'required',
        'value',
        'height',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): Field
    {
        $editor = new static();
        $editor->language($editor->get('language') ?? app()->getLocale());
        $editor->name($name);

        return $editor;
    }
}
