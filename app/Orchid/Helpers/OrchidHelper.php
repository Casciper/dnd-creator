<?php

namespace App\Orchid\Helpers;

use App\Enums\OrchidRoutes;
use App\Models\ProtoModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrchidHelper
{
    public static function getYesNoArray(): array
    {
        return [
            'Да' => 'Да',
            'Нет' => 'Нет',
        ];
    }

    public static function setAdminRoutes($code, string $listScreenClass, string $editScreenClass = null): void
    {
        Route::screen("/$code", $listScreenClass)->name("platform.$code.list");
        if (!is_null($editScreenClass)) {
            Route::screen("/$code/create", $editScreenClass)->name("platform.$code.create");
            Route::screen("/$code/{item}/edit", $editScreenClass)->name("platform.$code.edit");
        }
    }

    public static function getValidationStructure(string $name, array $defaults = []): array
    {
        $defaultRules = [];
        $existedMessageKeys = [];
        $modelRules = self::getPreset('validators', $name);

        if (empty($defaults)) {
            return $modelRules;
        }
        $defaultsPresets = self::getPreset('validators', 'defaults');

        if (empty($defaultsPresets)) {
            return $modelRules;
        }

        // создаём массив дефолтных правил валидации и сообщений
        foreach ($defaults as $default) {
            $defaultRules['rules'][$default] = $defaultsPresets['rules'][$default];
            $keys = array_keys($defaultsPresets['messages']);

            foreach ($keys as $key) {
                preg_match("~^$default\..*$~", $key, $matches);
                if (!empty($matches)) {
                    $existedMessageKeys[] = $matches[0];
                }
            }

            if (!empty($existedMessageKeys)) {
                foreach ($existedMessageKeys as $key) {
                    $defaultRules['messages'][$key] = $defaultsPresets['messages'][$key];
                }
            }
        }

        // мержим правила модели и дефолтные правила, при этом приоритет отдаётся правилам модели
        return array_merge_recursive($defaultRules, $modelRules);
    }

    public static function getPreset(string $title, ?string $block = null)
    {
        $path = 'presets.orchid.' . $title;
        if (!is_null($block)) {
            $path = $path . '.' . $block;
        }

        $data = config($path);
        return $data ?? [];
    }

    public static function setUniqueRule(array $presets, ProtoModel $item, string $fieldName, string $columnName, string $messageName): array
    {
        $presets['rules'][$fieldName][] = Rule::unique($item->getTable(), $columnName)->ignore($item->id);
        $presets['messages'][$fieldName . '.unique'] = "Такой $messageName уже используется";
        return $presets;
    }

    public static function validate(ProtoModel $item, OrchidRoutes $route, array $data, array $presets)
    {
        $validator = Validator::make($data, $presets['rules'], $presets['messages']);

        if ($validator->fails()) {
            $route = ($item->exists) ? $route->edit() : $route->create();
            return redirect()->route($route, $item->id)->withErrors($validator)->withInput();
        }
        return null;
    }

    public static function getValidator($data, $code, ?string $uniqueField = null, string $uniqueIdField = 'id'): \Illuminate\Validation\Validator
    {
        $presets = self::getPreset('validators', $code);
        if (!empty($uniqueField) && !empty($data[$uniqueIdField])) {
            foreach ($presets['rules'][$uniqueField] as &$fieldValidation) {
                if (Str::startsWith($fieldValidation, 'unique')) {
                    $fieldValidation .= ",{$uniqueIdField},{$data[$uniqueIdField]}";
                }
            }
        }
        return Validator::make($data, $presets['rules'], $presets['messages']);
    }

    public static function saveForSlug(ProtoModel $item, array &$data)
    {
        if ($item->exists) {
            $data['slug'] = $item->slug;
        } else {
            $item->fill($data)->save();
            $item->refresh();
            $data['slug'] = Str::slug($item->id . '-' . $data['title']);
        }
    }

    /** Quill даже без текста может отправлять тэги форматирования, из-за чего поле будет считаться не пустым и валидация required будет провалена
     * @param array $data - массив с данными из реквеста
     * @param array $fields - список полей, которые нужно проверить
     * @return void
     */
    public static function clearQuillTags(array &$data, array $fields)
    {
        foreach ($fields as $field) {
            $text = trim(strip_tags($data[$field]));
            if (empty($text)) {
                $data[$field] = $text;
            }
        }
    }
}
