<?php

use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$dbConnection = Database::getInstance()->getConnection();

$clientStmt = $dbConnection->query("SELECT id, first_name, last_name FROM clients ORDER BY last_name ASC");
$clients = $clientStmt->fetchAll(PDO::FETCH_ASSOC);

$caregiverStmt = $dbConnection->query("SELECT id, first_name, last_name FROM caregivers ORDER BY last_name ASC");
$caregivers = $caregiverStmt->fetchAll(PDO::FETCH_ASSOC);

$serviceStmt = $dbConnection->query("SELECT id, code, bill_rate FROM services");
$services = $serviceStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Appointment</title>
</head>

<body>
    <h1>Create New Appointment</h1>
    <form method="POST" action="../create-appointment.php">
        <label for="client_id">Client:</label><br>
        <select id="client_id" name="client_id" required>
            <option value="">Select a client</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo htmlspecialchars($client['id']); ?>">
                    <?php echo htmlspecialchars($client['last_name']) . ', ' . htmlspecialchars($client['first_name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="caregiver_id">Caregiver:</label><br>
        <select id="caregiver_id" name="caregiver_id" required>
            <option value="">Select a caregiver</option>
            <?php foreach ($caregivers as $caregiver): ?>
                <option value="<?php echo htmlspecialchars($caregiver['id']); ?>">
                    <?php echo htmlspecialchars($caregiver['last_name']) . ', ' . htmlspecialchars($caregiver['first_name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="service_id">Service:</label><br>
        <select id="service_id" name="service_id" required>
            <option value="">Select a service</option>
            <?php foreach ($services as $service): ?>
                <option value="<?php echo htmlspecialchars($service['id']); ?>">
                    <?php echo htmlspecialchars($service['code']) . ' - $' . htmlspecialchars($service['bill_rate']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required><br><br>

        <label for="start_time">Start Time:</label><br>
        <select id="start_time" name="start_time" data-start-time="12:00" required></select><br><br>

        <label for="end_time">End Time:</label><br>
        <select id="end_time" name="end_time" data-end-time="13:00" required></select><br><br>

        <label for="notes">Notes:</label><br>
        <textarea id="notes" name="notes"></textarea><br><br>

        <button type="submit">Create Appointment</button>
    </form>
    <script src="../../../../js/timeSelector.js"></script>
</body>

</html>
