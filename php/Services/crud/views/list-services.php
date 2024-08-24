<?php

use Services\ServiceRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$dbConnection = Database::getInstance()->getConnection();
$serviceRepo = new ServiceRepository($dbConnection);
$services = $serviceRepo->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
</head>

<body>
    <?php include '../../../nav.php'; ?>
    <h1>Services</h1>
    <?php if (!empty($services)): ?>
        <ul>
            <?php foreach ($services as $serviceItem): ?>
                <li>
                    <?php echo htmlspecialchars($serviceItem['id']); ?>
                    -
                    <?php echo htmlspecialchars($serviceItem['code']); ?>
                    -
                    <?php echo htmlspecialchars($serviceItem['description']); ?>
                    -
                    <?php echo htmlspecialchars($serviceItem['bill_rate']); ?>

                    <a href="../update-service.php?id=<?php echo htmlspecialchars($serviceItem['id']); ?>">Edit</a>

                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No services found.</p>
    <?php endif; ?>
    <a href="./create-service-form.php">Create New Service</a>
</body>

</html>
