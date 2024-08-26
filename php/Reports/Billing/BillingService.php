<?php

declare(strict_types=1);

namespace Reports\Billing;

class BillingService
{
    public function __construct(private BillingRepository $repository) {}

    public function getBillingReport(string $startDate, string $endDate): array
    {
        $data = $this->repository->fetchBillingData($startDate, $endDate);
        $report = [];

        foreach ($data as $row) {
            $visitHours = $this->calculateVisitHours($row['start_time'], $row['end_time']);
            $visitRevenue = $this->calculateVisitRevenue($visitHours, (float)$row['service_bill_rate']);

            $report[] = new BillingReport(
                (int)$row['client_id'],
                $row['client_first_name'],
                $row['client_last_name'],
                $row['service_code'],
                (float)$row['service_bill_rate'],
                $row['appointment_date'],
                $visitHours,
                $visitRevenue
            );
        }

        return $report;
    }

    private function calculateVisitHours(string $startTime, string $endTime): float
    {
        $start = new \DateTime($startTime);
        $end = new \DateTime($endTime);

        if ($end < $start) {
            $end->modify('+1 day');
        }

        $interval = $start->diff($end);

        return $interval->h + ($interval->i / 60);
    }

    private function calculateVisitRevenue(float $visitHours, float $billRate): float
    {
        return $visitHours * $billRate;
    }
}
