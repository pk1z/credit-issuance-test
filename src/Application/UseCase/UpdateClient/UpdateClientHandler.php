<?php

declare(strict_types=1);

namespace App\Application\UseCase\UpdateClient;

use App\Domain\Repository\ClientRepositoryInterface;
use DomainException;

class UpdateClientHandler
{
    public function __construct(private ClientRepositoryInterface $repository)
    {
    }

    public function __invoke(UpdateClientCommand $command): void
    {
        $client = $this->repository->find($command->clientId);

        if (!$client) {
            throw new DomainException('Client not found.');
        }

        if ($command->firstName) {
            $client->setFirstName($command->firstName);
        }

        if ($command->lastName) {
            $client->setLastName($command->lastName);
        }

        if ($command->age) {
            $client->setAge($command->age);
        }

        if ($command->creditScore) {
            $client->setCreditScore($command->creditScore);
        }

        if ($command->address) {
            $client->setAddress($command->address);
        }

        $this->repository->save($client);
    }
}
