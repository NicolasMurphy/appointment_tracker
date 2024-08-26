<?php

declare(strict_types=1);

namespace Reports\Billing;

use Database\Database;

class BillingController
{
    private BillingService $billingService;

    public function __construct()
    {
        $dbConnection = Database::getInstance()->getConnection();
        $billingRepository = new BillingRepository($dbConnection);
        $this->billingService = new BillingService($billingRepository);
    }

    public function handleRequest(): void
    {
        $defaultEndDate = (new \DateTime())->format('Y-m-d');
        $defaultStartDate = (new \DateTime('-1 week'))->format('Y-m-d');
        $startDate = filter_input(INPUT_GET, 'start_date', FILTER_SANITIZE_SPECIAL_CHARS) ?: $defaultStartDate;
        $endDate = filter_input(INPUT_GET, 'end_date', FILTER_SANITIZE_SPECIAL_CHARS) ?: $defaultEndDate;

        $report = $this->billingService->getBillingReport($startDate, $endDate);

        $this->renderView($report, $startDate, $endDate);
    }

    private function renderView(array $report, string $startDate, string $endDate): void
    {
        include 'billing-report-view.php';
    }
}
