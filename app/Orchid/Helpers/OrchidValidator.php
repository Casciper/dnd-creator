<?php

namespace App\Orchid\Helpers;

use App\Enums\OrchidRoutes;
use App\Models\ProtoModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as Valia;

class OrchidValidator
{
    protected array $dataForValidation = [];
    protected array $rules = [];
    protected array $messages = [];
    protected array $errors = [];
    protected string $presetsPath = 'presets.orchid.validators.defaults';
    protected ?Valia $validator;

    public function __construct(array $payload, array $defaultRules = [])
    {
        $this->dataForValidation = $payload;
        $this->rules = [];
        $this->messages = [];

        if (!empty($defaultRules)) {
            $presetRules = config($this->presetsPath);
            foreach ($defaultRules as $ruleKey) {
                if (isset($presetRules['rules'][$ruleKey])) {
                    $this->rules[$ruleKey] = $presetRules['rules'][$ruleKey];

                    $messages = [];
                    foreach ($presetRules['messages'] as $key => $message) {
                        if (Str::startsWith($key, $ruleKey)) {
                            $messages[$key] = $message;
                        }
                    }
                    $this->messages = array_merge($this->messages, $messages);
                }
            }
        }
    }

    public function setIndividualRules(array $rules, array $messages): static
    {
        $this->rules = array_merge($this->rules, $rules);
        $this->messages = array_merge($this->messages, $messages);

        return $this;
    }

    public function setUniqueFields(ProtoModel $item, array $uniqueFields,)
    {
        foreach ($uniqueFields as $field => $messages) {
            $this->rules[$field][] = Rule::unique($item->getTable(), $field)->ignore($item);
            $this->messages[$field . '.unique'] = $messages;
        }

        return $this;
    }

    public function validate()
    {
        $this->validator = Validator::make($this->dataForValidation, $this->rules, $this->messages);
        return $this;
    }

    public function getErrorsAsString(): string
    {
        $errors = $this->validator->getMessageBag()->getMessages();
        $this->collapseErrorsArray($errors);
        return implode(PHP_EOL, $this->errors);
    }

    public function getErrorsAsArray(): array
    {
        $errors = $this->validator->getMessageBag()->getMessages();
        $this->collapseErrorsArray($errors);
        return $this->errors;
    }

    public function isFail()
    {
        return $this->validator->fails();
    }

    public function showErrors(string|OrchidRoutes $route, ?int $id = null): RedirectResponse
    {
        $this->validator->errors()->getMessages();

        if (is_string($route)) {
            return redirect()->route($route, [$id])->withErrors($this->validator)->withInput();
        }
        if (is_null($id)) {
            return redirect()->route($route->create())->withErrors($this->validator)->withInput();
        }
        if ($route->isSingle()) {
            return redirect()->route($route->base(), [$id])->withErrors($this->validator)->withInput();
        }
        return redirect()->route($route->edit(), [$id])->withErrors($this->validator)->withInput();
    }

    public function getMessagesAndRules(): array
    {
        return [
            'rules' => $this->rules,
            'messages' => $this->messages,
        ];
    }

    /** Убирает тэги из поля Quill для проверки того, является ли оно действительно пустым
     * @param array $fields - список полей, которые нужно очистить от тегов
     * @return OrchidValidator
     */
    public function clearQuillTags(array $fields): static
    {
        foreach ($fields as $field) {
            $this->dataForValidation[$field] = trim(strip_tags($this->dataForValidation[$field]));
        }
        return $this;
    }

    public function getValdationData()
    {
        return $this->dataForValidation;
    }

    protected function collapseErrorsArray(array $errors): void
    {
        foreach ($errors as $key => $error) {
            if (is_array($error)) {
                $this->collapseErrorsArray($error);
            } else {
                $this->errors[$key] = $error;
            }
        }
    }
}
