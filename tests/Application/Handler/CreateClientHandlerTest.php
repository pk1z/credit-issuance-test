<?php

declare(strict_types=1);

namespace App\Tests\Application\Handler;

use App\Application\UseCase\CreateClient\CreateClientCommand;
use App\Application\UseCase\CreateClient\CreateClientHandler;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateClientHandlerTest extends TestCase
{
    public function testHandleCreatesClient(): void
    {
        $repositoryMock = $this->createMock(ClientRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Client::class))
        ;

        $command = new CreateClientCommand(
            'John',
            'Doe',
            30,
            700,
            'john.doe@example.com',
            '+123456789',
            new \App\Domain\ValueObject\Address('123 Main St', 'Los Angeles', 'CA', '90001')
        );

        $handler = new CreateClientHandler($repositoryMock);
        $client = $handler->__invoke($command);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals('John', $client->getFirstName());
        $this->assertEquals('Doe', $client->getLastName());
        $this->assertEquals(30, $client->getAge());
        $this->assertEquals(700, $client->getCreditScore());
    }
}
