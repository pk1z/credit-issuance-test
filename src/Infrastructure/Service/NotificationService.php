<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Service\NotificationServiceInterface;

class NotificationService implements NotificationServiceInterface
{
    private EmailSender $emailSender;
    private SmsSender $smsSender;

    public function __construct(EmailSender $emailSender, SmsSender $smsSender)
    {
        $this->emailSender = $emailSender;
        $this->smsSender = $smsSender;
    }

    public function sendEmail(string $email, string $message): void
    {
        $this->emailSender->send($email, $message);
    }

    public function sendSms(string $phoneNumber, string $message): void
    {
        $this->smsSender->send($phoneNumber, $message);
    }
}
