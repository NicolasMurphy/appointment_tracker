<?php

declare(strict_types=1);

namespace Reports\Payroll;

use Database\Database;

class PayrollController
{
    private PayrollService $payrollService;

    public function __construct()
    {
        $dbConnection = Database::getInstance()->getConnection();
        $payrollRepository = new PayrollRepository($dbConnection);
        $this->payrollService = new PayrollService($payrollRepository);
    }

    public function handleRequest(): void
    {
        $defaultEndDate = (new \DateTime())->format('Y-m-d');
        $defaultStartDate = (new \DateTime('-1 week'))->format('Y-m-d');
        $startDate = filter_input(INPUT_GET, 'start_date', FILTER_SANITIZE_SPECIAL_CHARS) ?: $defaultStartDate;
        $endDate = filter_input(INPUT_GET, 'end_date', FILTER_SANITIZE_SPECIAL_CHARS) ?: $defaultEndDate;

        $report = $this->payrollService->getPayrollReport($startDate, $endDate);

        $this->renderView($report, $startDate, $endDate);
    }

    private function renderView(array $report, string $startDate, string $endDate): void
    {
        include 'payroll-report-view.php';
    }
}
