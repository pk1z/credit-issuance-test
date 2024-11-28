<?php

declare(strict_types=1);

namespace App\Interface\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Client Schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'firstName', type: 'string', example: 'John'),
        new OA\Property(property: 'lastName', type: 'string', example: 'Doe'),
        new OA\Property(property: 'age', type: 'integer', example: 30),
        new OA\Property(property: 'creditScore', type: 'integer', example: 700),
        new OA\Property(property: 'email', type: 'string', example: 'john@email.com'),
        new OA\Property(property: 'phone', type: 'string', example: '1-800-555-5555'),
        new OA\Property(
            property: 'address',
            properties: [
                new OA\Property(property: 'street', type: 'string', example: '123 Main St'),
                new OA\Property(property: 'city', type: 'string', example: 'Los Angeles'),
                new OA\Property(property: 'state', type: 'string', example: 'CA'),
                new OA\Property(property: 'zip', type: 'string', example: '90001'),
            ],
            type: 'object'
        ),
    ]
)]
class ClientSchema
{
}
