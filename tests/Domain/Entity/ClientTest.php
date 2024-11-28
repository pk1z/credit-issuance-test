<?php

declare(strict_types=1);

namespace App\Tests\Domain\Entity;

use App\Domain\Entity\Client;
use App\Domain\ValueObject\Address;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testCreateClient(): void
    {
        $address = new Address('123 Main St', 'Los Angeles', 'CA', '90001');
        $client = new Client('John', 'Doe', 30, 700, 'john.doe@example.com', '+123456789', $address);

        $this->assertEquals('John', $client->getFirstName());
        $this->assertEquals('Doe', $client->getLastName());
        $this->assertEquals(30, $client->getAge());
        $this->assertEquals(700, $client->getCreditScore());
        $this->assertEquals('john.doe@example.com', $client->getEmail());
        $this->assertEquals('+123456789', $client->getPhone());
        $this->assertEquals($address, $client->getAddress());
    }

    public function testEligibilityForCredit(): void
    {
        $address = new Address('123 Main St', 'Los Angeles', 'CA', '90001');
        $client = new Client('John', 'Doe', 30, 700, 'john.doe@example.com', '+123456789', $address);

        $this->assertTrue($client->isEligibleForCredit());
    }

    public function testIneligibilityForCredit(): void
    {
        $address = new Address('123 Main St', 'Los Angeles', 'CA', '90001');
        $client = new Client('John', 'Doe', 25, 400, 'john.doe@example.com', '+123456789', $address);

        $this->assertFalse($client->isEligibleForCredit());
    }

    public function testSetAddress(): void
    {
        $client = new Client('John', 'Doe', 30, 700, 'john.doe@example.com', '+123456789', new Address('Old St', 'City', 'State', '12345'));
        $newAddress = new Address('123 Main St', 'Los Angeles', 'CA', '90001');

        $client->setAddress($newAddress);

        $this->assertEquals($newAddress, $client->getAddress());
    }
}
