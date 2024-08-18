<?php
require __DIR__ . '/../Appointment.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbConnection = Database::getInstance()->getConnection();
    $appointment = new Appointment($dbConnection);

    $clientId = (int)($_POST['client_id'] ?? 0);
    $caregiverId = (int)($_POST['caregiver_id'] ?? 0);
    $address = $_POST['address'] ?? '';
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['startTime'] ?? '';
    $endTime = $_POST['endTime'] ?? '';
    $notes = $_POST['notes'] ?? '';

    if ($clientId > 0 && $caregiverId > 0) {
        $appointment->setDetails($clientId, $caregiverId, $address, $date, $startTime, $endTime, $notes);

        if ($appointment->saveAppointment()) {
            header('Location: ../../../');
            exit();
        } else {
            echo "Failed to create appointment.";
        }
    } else {
        echo "Invalid client or caregiver selection.";
    }
}