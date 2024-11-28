<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateClient;

use App\Domain\ValueObject\Address;

class CreateClientCommand
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public int $age,
        public int $creditScore,
        public string $email,
        public string $phone,
        public Address $address,
    ) {
    }
}
