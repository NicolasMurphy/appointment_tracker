<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment</title>
</head>

<body>
    <h1>Update Appointment</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointmentDetails['id']); ?>">

        <label for="client_id">Client:</label><br>
        <select id="client_id" name="client_id" required>
            <option value="">Select a client</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo htmlspecialchars($client['id']); ?>" <?php echo $client['id'] == $appointmentDetails['client_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($client['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="caregiver_id">Caregiver:</label><br>
        <select id="caregiver_id" name="caregiver_id" required>
            <option value="">Select a caregiver</option>
            <?php foreach ($caregivers as $caregiver): ?>
                <option value="<?php echo htmlspecialchars($caregiver['id']); ?>" <?php echo $caregiver['id'] == $appointmentDetails['caregiver_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($caregiver['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($appointmentDetails['address']); ?>" required><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($appointmentDetails['date']); ?>" required><br><br>

        <label for="start_time">Start Time:</label><br>
        <select id="start_time" name="start_time" data-start-time="<?php echo htmlspecialchars($appointmentDetails['start_time']); ?>" required></select><br><br>

        <label for="end_time">End Time:</label><br>
        <select id="end_time" name="end_time" data-end-time="<?php echo htmlspecialchars($appointmentDetails['end_time']); ?>" required></select><br><br>

        <label for="notes">Notes:</label><br>
        <textarea id="notes" name="notes"><?php echo htmlspecialchars($appointmentDetails['notes']); ?></textarea><br><br>

        <button type="submit">Update Appointment</button>
    </form>
    <script src="../../../../js/timeSelector.js"></script>
</body>

</html>
