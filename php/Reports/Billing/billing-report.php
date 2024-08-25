<?php

declare(strict_types=1);

use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$defaultEndDate = (new DateTime())->format('Y-m-d');
$defaultStartDate = (new DateTime('-1 week'))->format('Y-m-d');

$startDateInput = filter_input(INPUT_GET, 'start_date', FILTER_SANITIZE_SPECIAL_CHARS) ?: $defaultStartDate;
$endDateInput = filter_input(INPUT_GET, 'end_date', FILTER_SANITIZE_SPECIAL_CHARS) ?: $defaultEndDate;

$startDate = DateTime::createFromFormat('Y-m-d', $startDateInput) !== false ? $startDateInput : null;
$endDate = DateTime::createFromFormat('Y-m-d', $endDateInput) !== false ? $endDateInput : null;

if (!$startDate || !$endDate) {
    die("Please provide a valid date range.");
}

$dbConnection = Database::getInstance()->getConnection();

$sql = "
SELECT
    clients.id AS client_id,
    clients.first_name AS client_first_name,
    clients.last_name AS client_last_name,
    services.code AS service_code,
    services.bill_rate AS service_bill_rate,
    appointments.date AS appointment_date,
    CASE
        WHEN appointments.end_time > appointments.start_time THEN
            TIMESTAMPDIFF(MINUTE, appointments.start_time, appointments.end_time) / 60
        ELSE
            (TIMESTAMPDIFF(MINUTE, appointments.start_time, appointments.end_time) + 1440) / 60
    END AS visit_hours,
    CASE
        WHEN appointments.end_time > appointments.start_time THEN
            (TIMESTAMPDIFF(MINUTE, appointments.start_time, appointments.end_time) / 60) * services.bill_rate
        ELSE
            ((TIMESTAMPDIFF(MINUTE, appointments.start_time, appointments.end_time) + 1440) / 60) * services.bill_rate
    END AS visit_revenue
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
    clients.last_name, clients.first_name, appointments.date, appointments.start_time;
";

$stmt = $dbConnection->prepare($sql);
$stmt->bindParam(':start_date', $startDate);
$stmt->bindParam(':end_date', $endDate);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalRevenueAllClients = 0;
$currentClientId = null;
$totalHoursPerClient = 0;
$totalRevenuePerClient = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Report</title>
</head>

<body>
    <?php include '../../nav.php'; ?>
    <h1>Billing Report</h1>

    <form method="get" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($startDateInput); ?>" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($endDateInput); ?>" required>

        <button type="submit">Generate Report</button>
    </form>

    <?php if (!empty($results)): ?>
        <h2>Report for <?php echo htmlspecialchars($startDate); ?> to <?php echo htmlspecialchars($endDate); ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Bill Rate</th>
                    <th>Visit Hours</th>
                    <th>Visit Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $index => $row): ?>
                    <?php
                    if ($currentClientId !== $row['client_id']) {
                        if ($currentClientId !== null) {
                            echo '<tr><td colspan="6" style="font-weight: bold;">Total Hours for ' . htmlspecialchars($previousClientName) . ': ' . rtrim(rtrim(number_format((float)$totalHoursPerClient, 2), '0'), '.') . '</td></tr>';
                            echo '<tr><td colspan="6" style="font-weight: bold;">Total Revenue for ' . htmlspecialchars($previousClientName) . ': $' . number_format((float)$totalRevenuePerClient, 2) . '</td></tr>';
                        }
                        $currentClientId = $row['client_id'];
                        $totalHoursPerClient = 0; // Reset
                        $totalRevenuePerClient = 0; // Reset
                    }
                    $previousClientName = htmlspecialchars($row['client_last_name']) . ', ' . htmlspecialchars($row['client_first_name']);
                    ?>
                    <tr>
                        <td><?php echo $previousClientName; ?></td>
                        <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_bill_rate']); ?></td>
                        <td><?php echo rtrim(rtrim(number_format((float)$row['visit_hours'], 2), '0'), '.'); ?></td>
                        <td><?php echo number_format((float)$row['visit_revenue'], 2); ?></td>
                    </tr>
                    <?php
                    $totalHoursPerClient += (float)$row['visit_hours'];
                    $totalRevenuePerClient += (float)$row['visit_revenue'];
                    $totalRevenueAllClients += (float)$row['visit_revenue'];
                    ?>
                    <?php if ($index === count($results) - 1): ?>
                        <tr>
                            <td colspan="6" style="font-weight: bold;">Total Hours for <?php echo $previousClientName; ?>: <?php echo rtrim(rtrim(number_format((float)$totalHoursPerClient, 2), '0'), '.'); ?></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="font-weight: bold;">Total Revenue for <?php echo $previousClientName; ?>: $<?php echo number_format((float)$totalRevenuePerClient, 2); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total Billed Revenue for All Clients: $<?php echo number_format((float)$totalRevenueAllClients, 2); ?></h3>
    <?php else: ?>
        <p>No verified appointments found for the given date range.</p>
    <?php endif; ?>
</body>

</html>
