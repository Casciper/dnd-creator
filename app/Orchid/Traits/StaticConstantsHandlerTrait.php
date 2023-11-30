<?php

    namespace App\Orchid\Traits;

    use Illuminate\Support\Str;
    use ReflectionClass;

    trait StaticConstantsHandlerTrait
    {
        /**
         * Получает массив содержаищй сообщения определённого типа констант
         * @param string $constantHead - строка для фильтрации констант. Например 'STATUS_' или 'TYPE_'
         * @return array - массив вида ['constant_message' => 'constant_message', ...]
         */
        public static function getValueToValueConstantsList(string $constantHead): array
        {
            // входящее значение SOME_TYPE_ будет преобразовано в строку getSomeTypeConstantMessage
            $method = 'get' . Str::ucfirst( Str::studly( Str::lower(( Str::beforeLast($constantHead, '_') )))) . 'ConstantMessage';
            $list = collect(self::getListConstantsOf($constantHead));
            return $list->map(fn ($value) => [self::$method($value) => self::$method($value)])->collapse()->toArray();
        }

        /**
         * Возвращает массив в котором в качестве ключей имена констант, а в качестве значений - их значения
         * @param string $constantHead - строка для фильтрации констант. Например 'STATUS_' или 'TYPE_'
         * @return array - массив вида ['CONSTANT_NAME' => 'constant_value', ...] отфильтрованных по их префиксу
         */
        public static function getListConstantsOf(string $constantHead): array
        {
            return collect(self::getAllConstants())->filter(fn($value, $key) => str_contains($key, $constantHead))->toArray();
        }

        /**
         * Получает список всех констант текущего класса
         * @return array - массив формата ['CONSTANT_NAME' => 'constant_value', ...]
         */
        protected static function getAllConstants(): array
        {
            $reflection = new ReflectionClass(self::class);
            return $reflection->getConstants();
        }
    }
