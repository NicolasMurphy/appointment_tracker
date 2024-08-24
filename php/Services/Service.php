<?php

declare(strict_types=1);

namespace Services;

class Service
{
    private ?int $id = null;
    private string $code;
    private string $description;
    private float $billRate;

    public function __construct(
        string $code,
        string $description,
        string $billRate
    ) {

        if (!$this->isValidPayRate($billRate)) {
            throw new \InvalidArgumentException("Invalid bill rate format. It should be a valid number.");
        }

        $this->code = $code;
        $this->description = $description;
        $this->billRate = (float) $billRate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBillRate(): float
    {
        return $this->billRate;
    }

    private function isValidPayRate(string $billRate): bool
    {
        return is_numeric($billRate) && $billRate > 0;
    }
}
