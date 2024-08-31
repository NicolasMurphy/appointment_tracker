<?php

declare(strict_types=1);

namespace Visits;

use DateTime;

class Visit
{
    private ?int $id = null;
    private int $clientId;
    private int $caregiverId;
    private int $serviceId;
    private string $date;
    private string $startTime;
    private string $endTime;
    private string $notes;
    private bool $verified;

    public function __construct(
        int $clientId,
        int $caregiverId,
        int $serviceId,
        string $date,
        string $startTime,
        string $endTime,
        ?string $notes = null,
        bool $verified = false
    ) {
        if (!$this->isValidDate($date)) {
            throw new \InvalidArgumentException("Invalid date format.");
        }

        if (!$this->isValidTime($startTime)) {
            throw new \InvalidArgumentException("Invalid start time format.");
        }

        if (!$this->isValidTime($endTime)) {
            throw new \InvalidArgumentException("Invalid end time format.");
        }

        $this->clientId = $clientId;
        $this->caregiverId = $caregiverId;
        $this->serviceId = $serviceId;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->notes = $notes ?? '';
        $this->verified = $verified;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getCaregiverId(): int
    {
        return $this->caregiverId;
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function isVerified(): bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): void
    {
        $this->verified = $verified;
    }

    private function isValidDate(string $date): bool
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    private function isValidTime(string $time): bool
    {
        $t = DateTime::createFromFormat('H:i', $time);
        return $t && $t->format('H:i') === $time;
    }
}
