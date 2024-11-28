<?php

declare(strict_types=1);

namespace App\Interface\Controller;

use App\Application\UseCase\CreateClient\CreateClientCommand;
use App\Domain\ValueObject\Address;
use App\Interface\OpenApi\Schemas\ClientSchema;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

use function is_array;
use function is_int;
use function is_string;
use function json_decode;

class CreateClientController
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route('/api/clients', name: 'create_client', methods: ['POST'])]
    #[OA\Post(
        description: 'Creates a new client with the provided data',
        summary: 'Create a new client',
        requestBody: new OA\RequestBody(
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
        responses: [
            new OA\Response(
                response: 201,
                description: 'Client created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Client created successfully.'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'errors', type: 'array', items: new OA\Items(type: 'string')),
                    ],
                    type: 'object'
                )
            ),
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $errors = $this->validateClientData($data);

        if (!empty($errors)) {
            return new JsonResponse(['status' => 'error', 'errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $command = new CreateClientCommand(
            $data['firstName'],
            $data['lastName'],
            $data['age'],
            $data['creditScore'],
            $data['email'],
            $data['phone'],
            new Address(
                $data['address']['street'],
                $data['address']['city'],
                $data['address']['state'],
                $data['address']['zip']
            )
        );

        $this->messageBus->dispatch($command);

        return new JsonResponse(['status' => 'Client creation started'], Response::HTTP_ACCEPTED);
    }

    private function validateClientData(array $data): array
    {
        $errors = [];

        if (empty($data['firstName']) || !is_string($data['firstName'])) {
            $errors[] = 'First name is required and must be a string.';
        }

        if (empty($data['lastName']) || !is_string($data['lastName'])) {
            $errors[] = 'Last name is required and must be a string.';
        }

        if (empty($data['age']) || !is_int($data['age']) || $data['age'] < 18 || $data['age'] > 60) {
            $errors[] = 'Age is required and must be an integer between 18 and 60.';
        }

        if (empty($data['creditScore']) || !is_int($data['creditScore']) || $data['creditScore'] < 300 || $data['creditScore'] > 850) {
            $errors[] = 'Credit score is required and must be an integer between 300 and 850.';
        }

        if (empty($data['address']) || !is_array($data['address'])) {
            $errors[] = 'Address is required and must be an object.';
        } else {
            $address = $data['address'];

            if (empty($address['street']) || !is_string($address['street'])) {
                $errors[] = 'Street is required and must be a string.';
            }

            if (empty($address['city']) || !is_string($address['city'])) {
                $errors[] = 'City is required and must be a string.';
            }

            if (empty($address['state']) || !is_string($address['state'])) {
                $errors[] = 'State is required and must be a string.';
            }

            if (empty($address['zip']) || !is_string($address['zip'])) {
                $errors[] = 'ZIP is required and must be a string.';
            }
        }

        return $errors;
    }
}
