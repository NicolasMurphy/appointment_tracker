<?php

declare(strict_types=1);

namespace Reports\Payroll;

class PayrollService
{
    public function __construct(private PayrollRepository $repository) {}

    public function getPayrollReport(string $startDate, string $endDate): array
    {
        $data = $this->repository->fetchPayrollData($startDate, $endDate);
        $report = [];

        foreach ($data as $row) {
            $visitHours = $this->calculateVisitHours($row['start_time'], $row['end_time']);
            $visitWages = $this->calculateVisitWages($visitHours, (float)$row['caregiver_pay_rate']);

            $report[] = new PayrollReport(
                $row['client_first_name'],
                $row['client_last_name'],
                $row['caregiver_first_name'],
                $row['caregiver_last_name'],
                (int)$row['caregiver_id'],
                (float)$row['caregiver_pay_rate'],
                $row['visit_date'],
                $visitHours,
                $visitWages
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

    private function calculateVisitWages(float $visitHours, float $payRate): float
    {
        return $visitHours * $payRate;
    }
}
