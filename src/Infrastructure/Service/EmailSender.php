<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

class EmailSender
{
    public function send(string $email, string $message): void
    {
        echo "Email sent to $email with message: $message\n";
    }
}
