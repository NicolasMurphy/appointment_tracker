<?php

use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$dbConnection = Database::getInstance()->getConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Service</title>
</head>

<body>
    <h1>Create New Service</h1>
    <form method="POST" action="../create-service.php">

        <label for="code">Service Code:</label><br>
        <input type="text" id="code" name="code" required><br><br>

        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" required><br><br>

        <label for="bill_rate">Bill Rate:</label><br>
        <input type="text" id="bill_rate" name="bill_rate" required><br><br>

        <button type="submit">Create Service</button>
    </form>
</body>

</html>
