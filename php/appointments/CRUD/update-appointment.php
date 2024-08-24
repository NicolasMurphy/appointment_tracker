<?php

use Appointments\Appointment;
use Appointments\AppointmentRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$appointmentDetails = null;

$dbConnection = Database::getInstance()->getConnection();
$appointmentRepo = new AppointmentRepository($dbConnection);

if ($id !== false && $id !== null) {
    $appointmentDetails = $appointmentRepo->fetchById($id);

    if (!$appointmentDetails) {
        echo "Appointment not found.";
        exit();
    }

    $clientStmt = $dbConnection->query("SELECT id, first_name, last_name FROM clients ORDER BY last_name ASC");
    $clients = $clientStmt->fetchAll(PDO::FETCH_ASSOC);

    $caregiverStmt = $dbConnection->query("SELECT id, first_name, last_name FROM caregivers ORDER BY last_name ASC");
    $caregivers = $caregiverStmt->fetchAll(PDO::FETCH_ASSOC);

    $serviceStmt = $dbConnection->query("SELECT id, code, bill_rate FROM services");
    $services = $serviceStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Invalid appointment ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $clientId = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);
    $caregiverId = filter_input(INPUT_POST, 'caregiver_id', FILTER_VALIDATE_INT);
    $serviceId = filter_input(INPUT_POST, 'service_id', FILTER_VALIDATE_INT);
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['start_time'] ?? '';
    $endTime = $_POST['end_time'] ?? '';
    $notes = $_POST['notes'] ?? '';

    if ($id !== false && $clientId !== false && $caregiverId !== false && $serviceId !== false) {
        $appointment = new Appointment($clientId, $caregiverId, $serviceId, $date, $startTime, $endTime, $notes);
        $appointment->setId($id);

        if ($appointmentRepo->update($appointment)) {
            header('Location: ../../../../');
            exit();
        } else {
            echo "Failed to update appointment.";
        }
    } else {
        echo "Invalid appointment ID, client ID, caregiver ID, or service ID.";
    }
}

include 'views/update-appointment-form.php';
