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

        <label for="client">Client:</label><br>
        <input type="text" id="client" name="client" value="<?php echo htmlspecialchars($appointmentDetails['client']); ?>" required><br><br>

        <label for="caregiver">Caregiver:</label><br>
        <input type="text" id="caregiver" name="caregiver" value="<?php echo htmlspecialchars($appointmentDetails['caregiver']); ?>" required><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($appointmentDetails['address']); ?>" required><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($appointmentDetails['date']); ?>" required><br><br>

        <label for="startTime">Start Time:</label><br>
        <select id="startTime" name="startTime" data-start-time="<?php echo htmlspecialchars($appointmentDetails['startTime']); ?>" required></select><br><br>

        <label for="endTime">End Time:</label><br>
        <select id="endTime" name="endTime" data-end-time="<?php echo htmlspecialchars($appointmentDetails['endTime']); ?>" required></select><br><br>

        <label for="notes">Notes:</label><br>
        <textarea id="notes" name="notes"><?php echo htmlspecialchars($appointmentDetails['notes']); ?></textarea><br><br>

        <button type="submit">Update Appointment</button>
    </form>
    <script src="../../../../js/timeSelector.js"></script>
</body>

</html>
