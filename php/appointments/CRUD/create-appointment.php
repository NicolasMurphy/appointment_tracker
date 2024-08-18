<?php
require __DIR__ . '/../Appointment.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment = new Appointment($db);

    $client = $_POST['client'] ?? '';
    $caregiver = $_POST['caregiver'] ?? '';
    $address = $_POST['address'] ?? '';
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['startTime'] ?? '';
    $endTime = $_POST['endTime'] ?? '';
    $notes = $_POST['notes'] ?? '';

    $appointment->setDetails($client, $caregiver, $address, $date, $startTime, $endTime, $notes);

    if ($appointment->save()) {
        header('Location: ../../../');
        exit();
    } else {
        echo "Failed to create appointment.";
    }
}
