<?php

declare(strict_types=1);

namespace App\Application\UseCase\IssueCredit;

class IssueCreditCommand
{
    public function __construct(
        public int $clientId,
        public int $amount,
        public int $term
    ) {}
}
