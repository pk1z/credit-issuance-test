<?php

declare(strict_types=1);

namespace App\Interface\Controller;

use App\Application\UseCase\UpdateClient\UpdateClientCommand;
use App\Domain\ValueObject\Address;
use App\Interface\OpenApi\Schemas\ClientSchema;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

use function json_decode;

class UpdateClientController
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route('/api/clients/{id}', name: 'update_client', methods: ['PUT'])]
    #[OA\Put(
        description: 'Update the details of an existing client by ID',
        summary: 'Update an existing client',
        requestBody: new OA\RequestBody(
            description: 'Client data to update',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        ref: new Model(type: ClientSchema::class)
                    ),
                ],
                type: 'object'
            )
        ),
        tags: ['Clients'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the client to update',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Client updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'Client updated successfully.'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Invalid data or validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Validation failed.'),
                    ],
                    type: 'object'
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
    public function __invoke(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new UpdateClientCommand(
            $id,
            $data['firstName'] ?? null,
            $data['lastName'] ?? null,
            $data['age'] ?? null,
            $data['creditScore'] ?? null,
            isset($data['address']) ? new Address(
                $data['address']['street'] ?? null,
                $data['address']['city'] ?? null,
                $data['address']['state'] ?? null,
                $data['address']['zip'] ?? null
            ) : null
        );

        $this->messageBus->dispatch($command);

        return new JsonResponse(['status' => 'Client updated successfully.'], Response::HTTP_OK);
    }
}
