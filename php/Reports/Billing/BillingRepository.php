<?php

declare(strict_types=1);

namespace Reports\Billing;

use PDO;

class BillingRepository
{
    public function __construct(private PDO $dbConnection) {}

    public function fetchBillingData(string $startDate, string $endDate): array
    {
        $sql = "
        SELECT
            clients.id AS client_id,
            clients.first_name AS client_first_name,
            clients.last_name AS client_last_name,
            caregivers.id AS caregiver_id,
            caregivers.first_name AS caregiver_first_name,
            caregivers.last_name AS caregiver_last_name,
            services.code AS service_code,
            services.bill_rate AS service_bill_rate,
            visits.date AS visit_date,
            visits.start_time,
            visits.end_time
        FROM
            visits
        JOIN
            clients ON visits.client_id = clients.id
        JOIN
            services ON visits.service_id = services.id
        JOIN
            caregivers ON visits.caregiver_id = caregivers.id
        WHERE
            visits.verified = 1
            AND visits.date BETWEEN :start_date AND :end_date
        ORDER BY
            visits.date, visits.start_time;
        ";

        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
