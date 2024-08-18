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
        <label for="client">Client:</label><br>
        <input type="text" id="client" name="client" required><br><br>

        <label for="caregiver">Caregiver:</label><br>
        <input type="text" id="caregiver" name="caregiver" required><br><br>

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
