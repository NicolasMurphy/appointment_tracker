<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
</head>

<body>
    <?php include 'nav.php'; ?>
    <h1>Client List</h1>
    <?php if (!empty($clients)): ?>
        <ul>
            <?php foreach ($clients as $clientItem): ?>
                <li>
                    <?php echo htmlspecialchars($clientItem['id']); ?>
                    -
                    <?php echo htmlspecialchars($clientItem['last_name']) . ', ' . htmlspecialchars($clientItem['first_name']); ?>
                    -
                    <?php echo htmlspecialchars($clientItem['email']); ?>
                    -
                    <?php echo htmlspecialchars($clientItem['phone_number']); ?>
                    -
                    <?php echo htmlspecialchars($clientItem['address']); ?>

                    <a href="?action=update&id=<?php echo htmlspecialchars($clientItem['id']); ?>">Edit</a>

                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No clients found.</p>
    <?php endif; ?>
    <a href="?action=create">Create New Client</a>
</body>

</html>
