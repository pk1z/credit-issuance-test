<?php

declare(strict_types=1);

namespace App\Interface\Controller;

use App\Application\UseCase\GetAllClients\GetAllClientsQuery;
use App\Interface\OpenApi\Schemas\ClientSchema;
use Nelmio\ApiDocBundle\Attribute\Model;
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
                            new OA\Property(
                                ref: new Model(type: ClientSchema::class)
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
