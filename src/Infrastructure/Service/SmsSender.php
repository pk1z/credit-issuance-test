<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

class SmsSender
{
    public function send(string $phoneNumber, string $message): void
    {
        echo "SMS sent to $phoneNumber with message: $message\n";
    }
}
