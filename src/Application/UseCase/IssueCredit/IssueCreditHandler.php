<?php

declare(strict_types=1);

namespace App\Application\UseCase\IssueCredit;

use App\Domain\Entity\Credit;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Repository\CreditRepositoryInterface;
use DomainException;

class IssueCreditHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private CreditRepositoryInterface $creditRepository,
    ) {
    }

    public function __invoke(IssueCreditCommand $command): Credit
    {
        $client = $this->clientRepository->find($command->clientId);

        if (!$client) {
            throw new DomainException('Client not found.');
        }

        if (!$client->isEligibleForCredit()) {
            throw new DomainException('Client is not eligible for credit.');
        }

        $state = $client->getAddress()->getState();
        $interestRate = $state === 'CA' ? 1050 + 1149 : 1050;

        $credit = new Credit($command->amount, $command->loanTerm, $interestRate);

        $this->creditRepository->save($credit);

        return $credit;
    }
}
