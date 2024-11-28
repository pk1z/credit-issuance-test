<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetClient;

class GetClientQuery
{
    public function __construct(public int $clientId)
    {
    }
}
