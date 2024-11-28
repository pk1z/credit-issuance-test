<?php

declare(strict_types=1);

namespace App\Application\UseCase\CheckCreditEligibility;

class CheckCreditEligibilityQuery
{
    public function __construct(public int $clientId) {}
}
