<?php

namespace App\Entity;

use App\Repository\MonetaryValueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonetaryValueRepository::class)]
class MonetaryValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $excludingVat = null;

    #[ORM\Column]
    private ?float $includingVat = null;

    #[ORM\Column]
    private ?float $vatRate = null;

    #[ORM\Column]
    private ?float $originalAmount = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $vatStatus = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExcludingVat(): ?float
    {
        return $this->excludingVat;
    }

    public function setExcludingVat(float $excludingVat): static
    {
        $this->excludingVat = $excludingVat;

        return $this;
    }

    public function getIncludingVat(): ?float
    {
        return $this->includingVat;
    }

    public function setIncludingVat(float $includingVat): static
    {
        $this->includingVat = $includingVat;

        return $this;
    }

    public function getVatRate(): ?float
    {
        return $this->vatRate;
    }

    public function setVatRate(float $vatRate): static
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    public function getOriginalAmount(): ?float
    {
        return $this->originalAmount;
    }

    public function setOriginalAmount(float $originalAmount): static
    {
        $this->originalAmount = $originalAmount;

        return $this;
    }

    public function getVatStatus(): ?string
    {
        return $this->vatStatus;
    }

    public function setVatStatus(string $vatStatus): static
    {
        $this->vatStatus = $vatStatus;

        return $this;
    }
}
