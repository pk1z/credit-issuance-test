<?php

declare(strict_types=1);

namespace App\Application\UseCase\UpdateClient;

use App\Domain\ValueObject\Address;

class UpdateClientCommand
{
    public function __construct(
        public int $clientId,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?int $age = null,
        public ?int $creditScore = null,
        public ?Address $address = null
    ) {}
}
