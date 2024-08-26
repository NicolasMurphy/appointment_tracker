<?php

declare(strict_types=1);

namespace Reports\Billing;

class BillingReport
{
    public function __construct(
        private int $clientId,
        private string $clientFirstName,
        private string $clientLastName,
        private string $serviceCode,
        private float $serviceBillRate,
        private string $appointmentDate,
        private float $visitHours,
        private float $visitRevenue
    ) {}

    public function getClientId(): int
    {
        return $this->clientId;
    }
    public function getClientFirstName(): string
    {
        return $this->clientFirstName;
    }
    public function getClientLastName(): string
    {
        return $this->clientLastName;
    }
    public function getServiceCode(): string
    {
        return $this->serviceCode;
    }
    public function getServiceBillRate(): float
    {
        return $this->serviceBillRate;
    }
    public function getAppointmentDate(): string
    {
        return $this->appointmentDate;
    }
    public function getVisitHours(): float
    {
        return $this->visitHours;
    }
    public function getVisitRevenue(): float
    {
        return $this->visitRevenue;
    }
}
