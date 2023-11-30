<?php

namespace App\Mail;

use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Mail;
use Throwable;

class DebugMailService
{
    protected CommonMailer $mailer;
    protected string $view;
    protected string $subject;
    protected array $recipients;

    public function __construct()
    {
        $site = config('app.name');
        $url = config('app.url');
        $mails = config('rocont.debug_mail');
        $this->subject = "На сайте $site - $url произошла ошибка!";
        $this->recipients = explode(',', $mails);
    }

    public function sendErrorVerboseMessage(Throwable $exception): void
    {
        $this->view = 'mails.errors.error-occur';
        $data['url'] = url()->full();
        $data['exception'] = $exception;
        $data['error'] = $exception->getMessage();
        $data['file'] = $exception->getFile() . ':' . $exception->getLine();
        $data['trace'] = $exception->getTraceAsString();
        $this->send($data);
    }

    protected function send(array $data): void
    {
        $mailer = new CommonMailer($data, $this->view);
        $mailer->subject = $this->subject;

        if (!CommonHelper::isEmpty($this->recipients)) {
            Mail::to($this->recipients)->send($mailer);
        }
    }

    public function sendShortErrorMessage(string $message): void
    {
        $this->view = 'mails.errors.error-summary';
        $data['info'] = $message;
        $this->send($data);
    }
}


