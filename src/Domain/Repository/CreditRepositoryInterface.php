<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Credit;

interface CreditRepositoryInterface
{
    public function save(Credit $credit): void;
}
