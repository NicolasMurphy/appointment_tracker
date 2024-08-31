<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Report</title>
</head>

<body>
    <?php include 'nav.php'; ?>
    <h1>Payroll Report</h1>

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
                    <th>Caregiver</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Pay Rate</th>
                    <th>Visit Hours</th>
                    <th>Visit Wages</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalHoursAllCaregivers = 0;
                $totalWagesAllCaregivers = 0;
                $totalHoursPerCaregiver = 0;
                $totalWagesPerCaregiver = 0;
                $currentCaregiverId = null;
                foreach ($report as $index => $payrollReport):
                    if ($currentCaregiverId !== $payrollReport->getCaregiverId()) {
                        if ($currentCaregiverId !== null) {
                            echo '<tr><td colspan="6" style="font-weight: bold;">Total Hours for ' . htmlspecialchars($previousCaregiverName) . ': ' . rtrim(rtrim(number_format($totalHoursPerCaregiver, 2), '0'), '.') . '</td></tr>';
                            echo '<tr><td colspan="6" style="font-weight: bold;">Total Wages for ' . htmlspecialchars($previousCaregiverName) . ': $' . number_format($totalWagesPerCaregiver, 2) . '</td></tr>';
                        }
                        $currentCaregiverId = $payrollReport->getCaregiverId();
                        $totalHoursPerCaregiver = 0; // Reset
                        $totalWagesPerCaregiver = 0; // Reset
                    }
                    $previousCaregiverName = htmlspecialchars($payrollReport->getCaregiverLastName()) . ', ' . htmlspecialchars($payrollReport->getCaregiverFirstName());
                ?>
                    <tr>
                        <td><?php echo $previousCaregiverName; ?></td>
                        <td><?php echo htmlspecialchars($payrollReport->getClientLastName()) . ', ' . htmlspecialchars($payrollReport->getClientFirstName()); ?></td>
                        <td><?php echo htmlspecialchars($payrollReport->getAppointmentDate()); ?></td>
                        <td><?php echo htmlspecialchars(number_format($payrollReport->getCaregiverPayRate(), 2)); ?></td>
                        <td><?php echo rtrim(rtrim(number_format($payrollReport->getVisitHours(), 2), '0'), '.'); ?></td>
                        <td><?php echo number_format($payrollReport->getVisitWages(), 2); ?></td>
                    </tr>
                    <?php
                    $totalHoursPerCaregiver += $payrollReport->getVisitHours();
                    $totalWagesPerCaregiver += $payrollReport->getVisitWages();
                    $totalHoursAllCaregivers += $payrollReport->getVisitHours();
                    $totalWagesAllCaregivers += $payrollReport->getVisitWages();
                    ?>
                    <?php if ($index === count($report) - 1): ?>
                        <tr>
                            <td colspan="6" style="font-weight: bold;">Total Hours for <?php echo $previousCaregiverName; ?>: <?php echo rtrim(rtrim(number_format($totalHoursPerCaregiver, 2), '0'), '.'); ?></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="font-weight: bold;">Total Wages for <?php echo $previousCaregiverName; ?>: $<?php echo number_format($totalWagesPerCaregiver, 2); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total Payed Hours for All Clients: <?php echo rtrim(rtrim(number_format($totalHoursAllCaregivers, 2), '0'), '.'); ?></h3>
        <h3>Total Payed Wages for All Caregivers: $<?php echo number_format($totalWagesAllCaregivers, 2); ?></h3>
    <?php else: ?>
        <p>No verified appointments found for the given date range.</p>
    <?php endif; ?>
</body>

</html>
