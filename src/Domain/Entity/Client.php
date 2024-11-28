<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Address;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastName;

    #[ORM\Column(type: 'integer')]
    private int $age;

    #[ORM\Column(type: 'integer')]
    private int $creditScore;

    #[ORM\Embedded(class: Address::class)]
    private Address $address;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;
    #[ORM\Column(type: 'string', length: 255)]
    private string $phone;

    public function __construct(
        string $firstName,
        string $lastName,
        int $age,
        int $creditScore,
        string $email,
        string $phone,
        Address $address,
    ) {
        if ($age < 18 || $age > 60) {
            throw new DomainException('Client age must be between 18 and 60.');
        }

        if ($creditScore < 300 || $creditScore > 850) {
            throw new DomainException('Credit score must be between 300 and 850.');
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->creditScore = $creditScore;
        $this->address = $address;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function isEligibleForCredit(): bool
    {
        return $this->creditScore > 500;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getCreditScore(): int
    {
        return $this->creditScore;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function setCreditScore(int $creditScore): void
    {
        $this->creditScore = $creditScore;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
}
