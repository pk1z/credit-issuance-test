<?php

declare(strict_types=1);

namespace App\Interface\Controller;

use App\Application\UseCase\IssueCredit\IssueCreditCommand;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

use function is_int;
use function json_decode;

class IssueCreditController
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route('/api/credits', name: 'issue_credit', methods: ['POST'])]
    #[OA\Post(
        description: 'Issues a credit to an eligible client',
        summary: 'Issue a credit',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'clientId', type: 'integer', example: 1),
                    new OA\Property(property: 'amount', type: 'number', format: 'integer', example: 5000),
                    new OA\Property(property: 'term', type: 'integer', example: 12),
                ],
                type: 'object'
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Credit issued successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'creditId', type: 'integer', example: 123),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Client is not eligible for credit',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Client is not eligible for credit.'),
                    ],
                    type: 'object'
                )
            ),
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $errors = $this->validateCreditData($data);

        if (!empty($errors)) {
            return new JsonResponse(['status' => 'error', 'errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $command = new IssueCreditCommand(
            $data['clientId'],
            $data['amount'],
            $data['term']
        );

        $this->messageBus->dispatch($command);

        return new JsonResponse(['status' => 'Credit issuance started'], JsonResponse::HTTP_ACCEPTED);
    }

    private function validateCreditData(array $data): array
    {
        $errors = [];

        if (empty($data['clientId']) || !is_int($data['clientId'])) {
            $errors[] = 'Client ID is required and must be an integer.';
        }

        if (empty($data['amount']) || !is_int($data['amount'])) {
            $errors[] = 'Amount is required and must be an integer.';
        }

        if (empty($data['term']) || !is_int($data['term']) || $data['term'] <= 0) {
            $errors[] = 'Term is required and must be a positive integer.';
        }

        return $errors;
    }
}
