<?php

declare(strict_types=1);

namespace Reports\Payroll;

class PayrollReport
{
    public function __construct(
        private string $clientFirstName,
        private string $clientLastName,
        private string $caregiverFirstName,
        private string $caregiverLastName,
        private int $caregiverId,
        private float $caregiverPayRate,
        private string $appointmentDate,
        private float $visitHours,
        private float $visitWages
    ) {}
    public function getClientFirstName(): string
    {
        return $this->clientFirstName;
    }
    public function getClientLastName(): string
    {
        return $this->clientLastName;
    }
    public function getCaregiverFirstName(): string
    {
        return $this->caregiverFirstName;
    }
    public function getCaregiverLastName(): string
    {
        return $this->caregiverLastName;
    }
    public function getCaregiverId(): int
    {
        return $this->caregiverId;
    }
    public function getCaregiverPayRate(): float
    {
        return $this->caregiverPayRate;
    }
    public function getAppointmentDate(): string
    {
        return $this->appointmentDate;
    }
    public function getVisitHours(): float
    {
        return $this->visitHours;
    }
    public function getVisitWages(): float
    {
        return $this->visitWages;
    }
}
