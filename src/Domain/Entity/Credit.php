<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Infrastructure\Repository\DoctrineCreditRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineCreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $productName = null;

    #[ORM\Column]
    private ?int $loanTerm = null;

    #[ORM\Column]
    private ?int $interestRate = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\ManyToOne]
    private ?Client $client = null;

    /**
     * @param int|null $loanTerm
     * @param int|null $amount
     * @param int|null $interestRate
     */
    public function __construct(?int $loanTerm, ?int $amount, ?int $interestRate)
    {
        $this->loanTerm = $loanTerm;
        $this->amount = $amount;
        $this->interestRate = $interestRate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): static
    {
        $this->productName = $productName;

        return $this;
    }

    public function getLoanTerm(): ?int
    {
        return $this->loanTerm;
    }

    public function setLoanTerm(int $loanTerm): static
    {
        $this->loanTerm = $loanTerm;

        return $this;
    }

    public function getInterestRate(): ?int
    {
        return $this->interestRate;
    }

    public function setInterestRate(int $interestRate): static
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
