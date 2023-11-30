<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class DateCompare implements Rule, DataAwareRule
{
    protected array $data = [];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $dateStart = Carbon::createFromFormat('Y-m-d H:i:s', $this->data['start_date']);
        $dateEnd = Carbon::createFromFormat('Y-m-d H:i:s', $this->data['end_date']);

        return ($dateStart->timestamp < $dateEnd->timestamp);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Дата начала не может быть позднее даты окончания';
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
