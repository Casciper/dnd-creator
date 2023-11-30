<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class NotElapsedDate implements Rule
{
    public function passes($attribute, $value)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $value);
        $date->addHour();
        return $date->timestamp > (Carbon::today())->timestamp;
    }

    public function message()
    {
        return 'Нельзя использовать прошедшую дату';
    }
}
