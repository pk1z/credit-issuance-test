<?php

declare(strict_types=1);

namespace App\Interface\Controller;

use App\Application\UseCase\GetClient\GetClientQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class GetClientController
{
    use HandleTrait;
    public function __construct(private MessageBusInterface $messageBus) {}

    #[Route('/api/clients/{id}', name: 'get_client', methods: ['GET'])]
    public function __invoke(int $id): JsonResponse
    {
        $query = new GetClientQuery($id);

        $clientData = $this->handle($query);

        return new JsonResponse($clientData);
    }
}
