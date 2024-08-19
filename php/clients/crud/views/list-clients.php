<?php
require __DIR__ . '/../../Client.php';

$dbConnection = Database::getInstance()->getConnection();
$client = new Client($dbConnection);
$clients = $client->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
</head>

<body>
    <?php include '../../../nav.php'; ?>
    <h1>Client List</h1>
    <?php if (!empty($clients)): ?>
        <ul>
            <?php foreach ($clients as $clientItem): ?>
                <li>
                    <?php echo htmlspecialchars($clientItem['id']); ?>
                    -
                    <?php echo htmlspecialchars($clientItem['first_name']); ?>
                    -
                    <?php echo htmlspecialchars($clientItem['last_name']); ?>
                    -
                    <?php echo htmlspecialchars($clientItem['email']); ?>
                    -
                    <?php echo htmlspecialchars($clientItem['phone_number']); ?>
                    -
                    <?php echo htmlspecialchars($clientItem['address']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No clients found.</p>
    <?php endif; ?>
    <a href="./create-client-form.php">Create New Client</a>
</body>

</html>
