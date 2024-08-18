<?php
require __DIR__ . '/../Appointment.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$appointmentDetails = null;

if ($id !== false && $id !== null) {
    $appointment = new Appointment($db);
    $appointmentDetails = $appointment->fetchById($id);

    if (!$appointmentDetails) {
        echo "Appointment not found.";
        exit();
    }
} else {
    echo "Invalid appointment ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $client = $_POST['client'] ?? '';
    $caregiver = $_POST['caregiver'] ?? '';
    $address = $_POST['address'] ?? '';
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['startTime'] ?? '';
    $endTime = $_POST['endTime'] ?? '';
    $notes = $_POST['notes'] ?? '';

    if ($id !== false && $id !== null) {
        $appointment->setId($id);
        $appointment->setDetails($client, $caregiver, $address, $date, $startTime, $endTime, $notes);

        if ($appointment->update()) {
            header('Location: ../../../../');
            exit();
        } else {
            echo "Failed to update appointment.";
        }
    } else {
        echo "Invalid appointment ID.";
    }
}

include 'views/update-form.php';
