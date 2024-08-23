<?php

use Appointments\Appointment;
use Appointments\AppointmentRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbConnection = Database::getInstance()->getConnection();
    $appointmentRepo = new AppointmentRepository($dbConnection);

    $clientId = (int)($_POST['client_id'] ?? 0);
    $caregiverId = (int)($_POST['caregiver_id'] ?? 0);
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['start_time'] ?? '';
    $endTime = $_POST['end_time'] ?? '';
    $notes = $_POST['notes'] ?? '';

    try {
        $appointment = new Appointment($clientId, $caregiverId, $date, $startTime, $endTime, $notes);

        if ($appointmentRepo->save($appointment)) {
            header('Location: ../../../');
            exit();
        } else {
            echo "Failed to create appointment.";
        }
    } catch (InvalidArgumentException $e) {
        echo "<p style='color:red;'>{$e->getMessage()}</p>";
    }
}
