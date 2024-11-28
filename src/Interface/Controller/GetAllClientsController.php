<?php

declare(strict_types=1);

namespace App\Interface\Controller;

use App\Application\UseCase\GetAllClients\GetAllClientsQuery;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class GetAllClientsController
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    #[Route('/api/clients', name: 'get_all_clients', methods: ['GET'])]
    #[OA\Get(
        description: 'Fetch a list of all registered clients',
        summary: 'Get all clients',
        tags: ['Clients'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of clients',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', example: 1),
                            new OA\Property(property: 'firstName', type: 'string', example: 'John'),
                            new OA\Property(property: 'lastName', type: 'string', example: 'Doe'),
                            new OA\Property(property: 'age', type: 'integer', example: 30),
                            new OA\Property(property: 'creditScore', type: 'integer', example: 700),
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
                        ],
                        type: 'object'
                    )
                )
            ),
        ]
    )]
    public function __invoke(): JsonResponse
    {
        $query = new GetAllClientsQuery();

        $clients = $this->handle($query);

        return new JsonResponse($clients, Response::HTTP_OK);
    }
}
