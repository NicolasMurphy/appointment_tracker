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
    <title>Create Caregiver</title>
</head>

<body>
    <h1>Create New Caregiver</h1>
    <form method="POST" action="../create-caregiver.php">

        <label for="first_name">First name:</label><br>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Last name:</label><br>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone_number">Phone Number:</label><br>
        <input type="tel" id="phone_number" name="phone_number" required><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br><br>

        <label for="pay_rate">Pay Rate:</label><br>
        <input type="text" id="pay_rate" name="pay_rate" required><br><br>


        <button type="submit">Create Caregiver</button>
    </form>
</body>

</html>