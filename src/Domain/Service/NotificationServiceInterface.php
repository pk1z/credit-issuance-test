<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface NotificationServiceInterface
{
    public function sendEmail(string $email, string $message): void;

    public function sendSms(string $phoneNumber, string $message): void;
}
