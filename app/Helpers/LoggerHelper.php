<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Throwable;

class LoggerHelper
{
    public static function commonError(string $message): void
    {
        Log::channel('common')->error($message);
    }

    public static function debug(string $message): void
    {
        Log::channel('debug')->debug($message);
    }

    public static function commonErrorVerbose(Throwable $throwable): void
    {
        $title = $throwable->getMessage();
        $file = $throwable->getFile() . ': ' . $throwable->getLine();
        $trace = $throwable->getTraceAsString();
        $message = $title . PHP_EOL . $file . PHP_EOL . $trace . PHP_EOL;
        Log::channel('common')->error($message);
    }
}
