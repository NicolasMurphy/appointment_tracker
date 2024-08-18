<?php
require __DIR__ . '/../../Appointment.php';

$dbConnection = Database::getInstance()->getConnection();

$clientStmt = $dbConnection->query("SELECT id, name FROM clients ORDER BY name ASC");
$clients = $clientStmt->fetchAll(PDO::FETCH_ASSOC);

$caregiverStmt = $dbConnection->query("SELECT id, name FROM caregivers ORDER BY name ASC");
$caregivers = $caregiverStmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <?php echo htmlspecialchars($client['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="caregiver_id">Caregiver:</label><br>
        <select id="caregiver_id" name="caregiver_id" required>
            <option value="">Select a caregiver</option>
            <?php foreach ($caregivers as $caregiver): ?>
                <option value="<?php echo htmlspecialchars($caregiver['id']); ?>">
                    <?php echo htmlspecialchars($caregiver['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required><br><br>

        <label for="startTime">Start Time:</label><br>
        <select id="startTime" name="startTime" data-start-time="12:00" required></select><br><br>

        <label for="endTime">End Time:</label><br>
        <select id="endTime" name="endTime" data-end-time="13:00" required></select><br><br>

        <label for="notes">Notes:</label><br>
        <textarea id="notes" name="notes"></textarea><br><br>

        <button type="submit">Create Appointment</button>
    </form>
    <script src="../../../../js/timeSelector.js"></script>
</body>

</html>
