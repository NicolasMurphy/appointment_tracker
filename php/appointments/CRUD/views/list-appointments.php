<?php
require __DIR__ . '/../../Appointment.php';

$dbConnection = Database::getInstance()->getConnection();
$appointment = new Appointment($dbConnection);
$appointments = $appointment->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment List</title>
</head>

<body>
    <h1>Appointment List</h1>
    <?php if (!empty($appointments)): ?>
        <ul id="appointment-list">
            <?php foreach ($appointments as $appointmentItem): ?>
                <li data-client="<?php echo htmlspecialchars($appointmentItem['client_last_name']); ?>" data-caregiver="<?php echo htmlspecialchars($appointmentItem['caregiver_last_name']); ?>" data-date="<?php echo htmlspecialchars($appointmentItem['date']); ?>">
                    Client: <?php echo htmlspecialchars($appointmentItem['client_first_name']) . ' ' . htmlspecialchars($appointmentItem['client_last_name']); ?>
                    - Caregiver:
                    <?php echo htmlspecialchars($appointmentItem['caregiver_first_name']) . ' ' . htmlspecialchars($appointmentItem['caregiver_last_name']); ?>
                    -
                    <?php echo htmlspecialchars($appointmentItem['date']); ?>
                    from
                    <?php echo htmlspecialchars($appointmentItem['start_time']); ?>
                    to
                    <?php echo htmlspecialchars($appointmentItem['end_time']); ?>
                    -
                    <?php echo htmlspecialchars($appointmentItem['notes']); ?>

                    <a href="./php/appointments/crud/update-appointment.php?id=<?php echo htmlspecialchars($appointmentItem['id']); ?>">Edit</a>

                    <form method="POST" action="./php/appointments/crud/delete-appointment.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointmentItem['id']); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No appointments found.</p>
    <?php endif; ?>
    <a href="./php/appointments/crud/views/create-form.php">Create New Appointment</a>
    <script type="module" src="js/sortFunctions.js"></script>
</body>

</html>
