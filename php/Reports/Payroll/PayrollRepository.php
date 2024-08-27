<?php

declare(strict_types=1);

namespace Reports\Payroll;

use PDO;

class PayrollRepository
{
    public function __construct(private PDO $dbConnection) {}

    public function fetchPayrollData(string $startDate, string $endDate): array
    {
        $sql = "
        SELECT
            clients.first_name AS client_first_name,
            clients.last_name AS client_last_name,
            caregivers.id AS caregiver_id,
            caregivers.first_name AS caregiver_first_name,
            caregivers.last_name AS caregiver_last_name,
            caregivers.pay_rate AS caregiver_pay_rate,
            appointments.date AS appointment_date,
            appointments.start_time,
            appointments.end_time
        FROM
            appointments
        JOIN
            clients ON appointments.client_id = clients.id
        JOIN
            caregivers ON appointments.caregiver_id = caregivers.id
        WHERE
            appointments.verified = 1
            AND appointments.date BETWEEN :start_date AND :end_date
        ORDER BY
            appointments.date, appointments.start_time;
        ";

        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
