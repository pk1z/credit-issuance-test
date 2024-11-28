<?php

declare(strict_types=1);

namespace App\Application\UseCase\CheckCreditEligibility;

use App\Domain\Repository\ClientRepositoryInterface;

class CheckCreditEligibilityHandler
{
    public function __construct(private ClientRepositoryInterface $repository) {}

    public function __invoke(CheckCreditEligibilityQuery $query): bool
    {
        $client = $this->repository->find($query->clientId);

        if (!$client) {
            throw new \DomainException('Client not found.');
        }

        return $client->isEligibleForCredit();
    }
}
