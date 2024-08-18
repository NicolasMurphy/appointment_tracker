<?php
require __DIR__ . '/../../Appointment.php';

$appointment = new Appointment($db);
$appointments = $appointment->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments List</title>
</head>

<body>
    <h1>Appointment List</h1>
    <?php if (!empty($appointments)): ?>
        <ul id="appointment-list">
            <?php foreach ($appointments as $appointmentItem): ?>
                <li data-client="<?php echo htmlspecialchars($appointmentItem['client']); ?>" data-caregiver="<?php echo htmlspecialchars($appointmentItem['caregiver']); ?>" data-date="<?php echo htmlspecialchars($appointmentItem['date']); ?>">
                    Client: <?php echo htmlspecialchars($appointmentItem['client']); ?> - Caregiver: <?php echo htmlspecialchars($appointmentItem['caregiver']); ?> - <?php echo htmlspecialchars($appointmentItem['address']); ?> - <?php echo htmlspecialchars($appointmentItem['date']); ?> from <?php echo htmlspecialchars($appointmentItem['startTime']); ?> to <?php echo htmlspecialchars($appointmentItem['endTime']); ?> - <?php echo htmlspecialchars($appointmentItem['notes']); ?>

                    <a href="./php/appointments/CRUD/update-appointment.php?id=<?php echo htmlspecialchars($appointmentItem['id']); ?>">Edit</a>

                    <form method="POST" action="./php/appointments/CRUD/delete-appointment.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointmentItem['id']); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No appointments found.</p>
    <?php endif; ?>
    <script type="module" src="js/sortFunctions.js"></script>
</body>

</html>
