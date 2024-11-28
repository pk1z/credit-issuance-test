<?php

declare(strict_types=1);

namespace App\Tests\Application\Handler;

use App\Application\UseCase\CheckCreditEligibility\CheckCreditEligibilityHandler;
use App\Application\UseCase\CheckCreditEligibility\CheckCreditEligibilityQuery;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use DomainException;
use PHPUnit\Framework\TestCase;

class CheckCreditEligibilityHandlerTest extends TestCase
{
    public function testHandleReturnsEligibility(): void
    {
        $clientMock = $this->createMock(Client::class);
        $clientMock->method('isEligibleForCredit')
            ->willReturn(true)
        ;

        $repositoryMock = $this->createMock(ClientRepositoryInterface::class);
        $repositoryMock->method('find')
            ->with(1)
            ->willReturn($clientMock)
        ;

        $handler = new CheckCreditEligibilityHandler($repositoryMock);
        $query = new CheckCreditEligibilityQuery(1);
        $isEligible = $handler->__invoke($query);

        $this->assertTrue($isEligible);
    }

    public function testHandleThrowsExceptionForNonexistentClient(): void
    {
        $repositoryMock = $this->createMock(ClientRepositoryInterface::class);
        $repositoryMock->method('find')
            ->with(1)
            ->willReturn(null)
        ;

        $handler = new CheckCreditEligibilityHandler($repositoryMock);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Client not found.');

        $handler->__invoke(new CheckCreditEligibilityQuery(1));
    }
}
