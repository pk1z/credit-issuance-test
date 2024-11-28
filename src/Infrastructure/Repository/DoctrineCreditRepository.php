<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Credit;
use App\Domain\Repository\CreditRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCreditRepository implements CreditRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Credit $credit): void
    {
        $this->entityManager->persist($credit);
        $this->entityManager->flush();
    }
}
