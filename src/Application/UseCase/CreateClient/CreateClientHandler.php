<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateClient;

use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;

class CreateClientHandler
{
    public function __construct(private ClientRepositoryInterface $repository) {}

    public function __invoke(CreateClientCommand $command): Client
    {
        $client = new Client(
            $command->firstName,
            $command->lastName,
            $command->age,
            $command->creditScore,
            $command->email,
            $command->phone,
            $command->address
        );

        $this->repository->save($client);

        return $client;
    }
}
