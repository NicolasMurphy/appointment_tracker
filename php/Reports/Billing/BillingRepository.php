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
            services.code AS service_code,
            services.bill_rate AS service_bill_rate,
            appointments.date AS appointment_date,
            appointments.start_time,
            appointments.end_time
        FROM
            appointments
        JOIN
            clients ON appointments.client_id = clients.id
        JOIN
            services ON appointments.service_id = services.id
        WHERE
            appointments.verified = 1
            AND appointments.date BETWEEN :start_date AND :end_date
        ORDER BY
            clients.last_name, appointments.date, appointments.start_time;
        ";

        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
