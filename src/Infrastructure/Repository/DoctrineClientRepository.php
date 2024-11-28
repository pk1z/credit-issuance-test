<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineClientRepository implements ClientRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function find(int $id): ?Client
    {
        return $this->entityManager->getRepository(Client::class)->find($id);
    }

    public function save(Client $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Client::class)->findAll();
    }
}
