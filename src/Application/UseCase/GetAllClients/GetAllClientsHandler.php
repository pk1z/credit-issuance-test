<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetAllClients;

use App\Domain\Repository\ClientRepositoryInterface;

use function array_map;

class GetAllClientsHandler
{
    public function __construct(private ClientRepositoryInterface $repository)
    {
    }

    public function __invoke(GetAllClientsQuery $query): array
    {
        $clients = $this->repository->findAll();

        return array_map(function ($client) {
            return [
                'id' => $client->getId(),
                'firstName' => $client->getFirstName(),
                'lastName' => $client->getLastName(),
                'age' => $client->getAge(),
                'creditScore' => $client->getCreditScore(),
                'email' => $client->getEmail(),
                'phone' => $client->getPhone(),
                'address' => $client->getAddress()->toArray(),
            ];
        }, $clients);
    }
}
