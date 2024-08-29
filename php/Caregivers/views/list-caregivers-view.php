<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caregiver List</title>
</head>

<body>
    <?php include 'nav.php'; ?>
    <h1>Caregiver List</h1>
    <?php if (!empty($caregivers)): ?>
        <ul>
            <?php foreach ($caregivers as $caregiverItem): ?>
                <li>
                    <?php echo htmlspecialchars($caregiverItem['id']); ?>
                    -
                    <?php echo htmlspecialchars($caregiverItem['last_name']) . ', ' . htmlspecialchars($caregiverItem['first_name']); ?>
                    -
                    <?php echo htmlspecialchars($caregiverItem['email']); ?>
                    -
                    <?php echo htmlspecialchars($caregiverItem['phone_number']); ?>
                    -
                    <?php echo htmlspecialchars($caregiverItem['address']); ?>
                    -
                    <?php echo htmlspecialchars($caregiverItem['pay_rate']); ?>

                    <a href="?action=update&id=<?php echo htmlspecialchars($caregiverItem['id']); ?>">Edit</a>

                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No caregivers found.</p>
    <?php endif; ?>
    <a href="?action=create">Create New Caregiver</a>
</body>

</html>
