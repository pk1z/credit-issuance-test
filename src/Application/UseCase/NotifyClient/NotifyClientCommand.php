<?php

declare(strict_types=1);

namespace App\Application\UseCase\NotifyClient;

class NotifyClientCommand
{
    public function __construct(
        public int $clientId,
        public string $message,
        public string $channel, // 'email' или 'sms'
    ) {
    }
}
