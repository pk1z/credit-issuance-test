<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Address
{
    #[ORM\Column(type: 'string', length: 255)]
    private string $street;

    #[ORM\Column(type: 'string', length: 255)]
    private string $city;

    #[ORM\Column(type: 'string', length: 2)]
    private string $state;

    #[ORM\Column(type: 'string', length: 10)]
    private string $zip;

    public function __construct(string $street, string $city, string $state, string $zip)
    {
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function toArray(): array
    {
        return [
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
        ];
    }
}
