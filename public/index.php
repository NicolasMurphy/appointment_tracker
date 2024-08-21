<?php
require_once '/var/www/html/vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Tracker PHP</title>
</head>

<body>
    <?php include './php/nav.php'; ?>
    <?php include './php/Appointments/crud/views/list-appointments.php'; ?>
</body>

</html>
