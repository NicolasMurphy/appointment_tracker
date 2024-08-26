<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Report</title>
</head>

<body>
    <?php include 'nav.php'; ?>
    <h1>Billing Report</h1>

    <form method="get" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>" required>

        <button type="submit">Generate Report</button>
    </form>

    <?php if (!empty($report)): ?>
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
                <?php
                $totalRevenueAllClients = 0;
                $totalHoursPerClient = 0;
                $totalRevenuePerClient = 0;
                $currentClientId = null;
                foreach ($report as $index => $billingReport):
                    if ($currentClientId !== $billingReport->getClientId()) {
                        if ($currentClientId !== null) {
                            echo '<tr><td colspan="6" style="font-weight: bold;">Total Hours for ' . htmlspecialchars($previousClientName) . ': ' . rtrim(rtrim(number_format($totalHoursPerClient, 2), '0'), '.') . '</td></tr>';
                            echo '<tr><td colspan="6" style="font-weight: bold;">Total Revenue for ' . htmlspecialchars($previousClientName) . ': $' . number_format($totalRevenuePerClient, 2) . '</td></tr>';
                        }
                        $currentClientId = $billingReport->getClientId();
                        $totalHoursPerClient = 0; // Reset
                        $totalRevenuePerClient = 0; // Reset
                    }
                    $previousClientName = htmlspecialchars($billingReport->getClientLastName()) . ', ' . htmlspecialchars($billingReport->getClientFirstName());
                ?>
                    <tr>
                        <td><?php echo $previousClientName; ?></td>
                        <td><?php echo htmlspecialchars($billingReport->getAppointmentDate()); ?></td>
                        <td><?php echo htmlspecialchars($billingReport->getServiceCode()); ?></td>
                        <td><?php echo htmlspecialchars(number_format($billingReport->getServiceBillRate(), 2)); ?></td>
                        <td><?php echo rtrim(rtrim(number_format($billingReport->getVisitHours(), 2), '0'), '.'); ?></td>
                        <td><?php echo number_format($billingReport->getVisitRevenue(), 2); ?></td>
                    </tr>
                    <?php
                    $totalHoursPerClient += $billingReport->getVisitHours();
                    $totalRevenuePerClient += $billingReport->getVisitRevenue();
                    $totalRevenueAllClients += $billingReport->getVisitRevenue();
                    ?>
                    <?php if ($index === count($report) - 1): ?>
                        <tr>
                            <td colspan="6" style="font-weight: bold;">Total Hours for <?php echo $previousClientName; ?>: <?php echo rtrim(rtrim(number_format($totalHoursPerClient, 2), '0'), '.'); ?></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="font-weight: bold;">Total Revenue for <?php echo $previousClientName; ?>: $<?php echo number_format($totalRevenuePerClient, 2); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total Billed Revenue for All Clients: $<?php echo number_format($totalRevenueAllClients, 2); ?></h3>
    <?php else: ?>
        <p>No verified appointments found for the given date range.</p>
    <?php endif; ?>
</body>

</html>
