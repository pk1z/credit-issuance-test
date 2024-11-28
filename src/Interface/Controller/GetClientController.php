<?php

declare(strict_types=1);

namespace App\Interface\Controller;

use App\Application\UseCase\GetClient\GetClientQuery;
use App\Interface\OpenApi\Schemas\ClientSchema;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class GetClientController
{
    use HandleTrait;
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[OA\Get(
        description: 'Fetch details of a client based on the provided ID.',
        summary: 'Get a specific client by ID',
        tags: ['Clients'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the client to retrieve',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Client retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            ref: new Model(type: ClientSchema::class)
                        ),
                    ],
                    type: 'object',
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Client not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Client not found.'),
                    ],
                    type: 'object'
                )
            ),
        ]
    )]
    #[Route('/api/clients/{id}', name: 'get_client', methods: ['GET'])]
    public function __invoke(int $id): JsonResponse
    {
        $query = new GetClientQuery($id);

        $clientData = $this->handle($query);

        return new JsonResponse($clientData);
    }
}
