<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetClient;

use App\Domain\Repository\ClientRepositoryInterface;
use DomainException;

class GetClientHandler
{
    public function __construct(private ClientRepositoryInterface $repository)
    {
    }

    public function __invoke(GetClientQuery $query): array
    {
        $client = $this->repository->find($query->clientId);

        if (!$client) {
            throw new DomainException('Client not found.');
        }

        return [
            'id' => $client->getId(),
            'firstName' => $client->getFirstName(),
            'lastName' => $client->getLastName(),
            'age' => $client->getAge(),
            'creditScore' => $client->getCreditScore(),
            'address' => $client->getAddress()->toArray(),
        ];
    }
}
