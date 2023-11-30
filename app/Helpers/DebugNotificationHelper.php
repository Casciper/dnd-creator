<?php

namespace App\Helpers;

use App\Mail\DebugMailService;
use Throwable;

class DebugNotificationHelper
{
    public static function sendVerboseErrorEmail(Throwable $exception): void
    {
        $mailer = new DebugMailService();
        $mailer->sendErrorVerboseMessage($exception);
    }

    public static function sendShortErrorMessage(string $exception): void
    {
        $mailer = new DebugMailService();
        $mailer->sendShortErrorMessage($exception);
    }
}
