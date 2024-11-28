<?php

declare(strict_types=1);

namespace App\Application\UseCase\NotifyClient;

use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Service\NotificationServiceInterface;
use DomainException;
use InvalidArgumentException;

class NotifyClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $repository,
        private NotificationServiceInterface $notificationService,
    ) {
    }

    public function __invoke(NotifyClientCommand $command): void
    {
        $client = $this->repository->find($command->clientId);

        if (!$client) {
            throw new DomainException('Client not found.');
        }

        if ($command->channel === 'email') {
            $this->notificationService->sendEmail($client->getEmail(), $command->message);
        } elseif ($command->channel === 'sms') {
            $this->notificationService->sendSms($client->getPhone(), $command->message);
        } else {
            throw new InvalidArgumentException('Invalid notification channel.');
        }
    }
}
