<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment List</title>
</head>

<body>
    <?php include './nav.php'; ?>
    <h1>Appointment List</h1>
    <?php if (!empty($appointments)): ?>
        <ul id="appointment-list">
            <?php foreach ($appointments as $appointmentItem): ?>
                <li data-client="<?php echo htmlspecialchars($appointmentItem['client_last_name']); ?>" data-caregiver="<?php echo htmlspecialchars($appointmentItem['caregiver_last_name']); ?>" data-date="<?php echo htmlspecialchars($appointmentItem['date']); ?>">
                    Client: <?php echo htmlspecialchars($appointmentItem['client_last_name']) . ', ' . htmlspecialchars($appointmentItem['client_first_name']); ?>
                    -
                    Caregiver:
                    <?php echo htmlspecialchars($appointmentItem['caregiver_last_name']) . ', ' . htmlspecialchars($appointmentItem['caregiver_first_name']); ?>
                    -
                    Service:
                    <?php echo htmlspecialchars($appointmentItem['service_code']) . ' - $' . htmlspecialchars($appointmentItem['service_bill_rate']) ?>
                    -
                    <?php echo htmlspecialchars($appointmentItem['date']); ?>
                    from
                    <?php echo htmlspecialchars($appointmentItem['start_time']); ?>
                    to
                    <?php echo htmlspecialchars($appointmentItem['end_time']); ?>
                    -
                    <?php echo htmlspecialchars($appointmentItem['notes']); ?>

                    <form method="POST" action="/php/appointments.php?action=verify" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointmentItem['id']); ?>">
                        <input type="hidden" name="verified" value="0">
                        <input type="checkbox" name="verified" value="1" <?php echo $appointmentItem['verified'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                        Verified
                    </form>

                    <a href="?action=update&id=<?php echo htmlspecialchars($appointmentItem['id']); ?>">Edit</a>

                    <form method="POST" action="/php/appointments.php?action=delete" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointmentItem['id']); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No appointments found.</p>
    <?php endif; ?>
    <a href="/php/appointments.php?action=create">Create New Appointment</a>
    <script type="module" src="js/sortFunctions.js"></script>
</body>

</html>
