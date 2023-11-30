<?php

namespace App\Mail;

class ManagerMailService extends AbstractMailService
{
    public function __construct(string|array $email = null)
    {
        $this->debugMails = explode(',', config('rocont.debug_mails'));

        if (is_null($email)) {
            $this->prodMails = explode(',', config('rocont.main_mails'));
        } else {
            $this->prodMails = is_array($email) ? $email : [$email];
        }
    }

    public function addEmail(string|array $mail): static
    {
        if (is_array($mail)) {
            $this->prodMails = array_merge($this->prodMails, $mail);
        } else {
            $this->prodMails[] = $mail;
        }
        return $this;
    }

    public function setView(string $view)
    {
        $this->view = 'admin.' . $view;
        return $this;
    }

    public function regularMailMethod(array $formData, string $subject): bool
    {
        $this->subject = $subject;
        return $this->send($formData);
    }
}
