<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Client;

interface ClientRepositoryInterface
{
    public function find(int $id): ?Client;

    /**
     * @return Client[]
     */
    public function findAll(): array;

    public function save(Client $client): void;
}
