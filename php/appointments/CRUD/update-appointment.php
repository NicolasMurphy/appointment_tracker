<?php
require __DIR__ . '/../Appointment.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$appointmentDetails = null;

if ($id !== false && $id !== null) {
    $dbConnection = Database::getInstance()->getConnection();
    $appointment = new Appointment($dbConnection);
    $appointmentDetails = $appointment->fetchById($id);

    if (!$appointmentDetails) {
        echo "Appointment not found.";
        exit();
    }

    $clientStmt = $dbConnection->query("SELECT id, name FROM clients ORDER BY name ASC");
    $clients = $clientStmt->fetchAll(PDO::FETCH_ASSOC);

    $caregiverStmt = $dbConnection->query("SELECT id, name FROM caregivers ORDER BY name ASC");
    $caregivers = $caregiverStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Invalid appointment ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_VALIDATE_INT);
    $caregiverId = filter_input(INPUT_POST, 'caregiverId', FILTER_VALIDATE_INT);
    $address = $_POST['address'] ?? '';
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['startTime'] ?? '';
    $endTime = $_POST['endTime'] ?? '';
    $notes = $_POST['notes'] ?? '';

    if ($id !== false && $clientId !== false && $caregiverId !== false) {
        $appointment->setId($id);
        $appointment->setDetails($clientId, $caregiverId, $address, $date, $startTime, $endTime, $notes);

        if ($appointment->updateAppointment()) {
            header('Location: ../../../../');
            exit();
        } else {
            echo "Failed to update appointment.";
        }
    } else {
        echo "Invalid appointment ID, client ID, or caregiver ID.";
    }
}

include 'views/update-form.php';
