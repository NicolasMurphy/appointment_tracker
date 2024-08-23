<?php

use Appointments\AppointmentRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$dbConnection = Database::getInstance()->getConnection();
$appointmentRepo = new AppointmentRepository($dbConnection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null) {
        if ($appointmentRepo->delete($id)) {
            header('Location: ../../../');
            exit();
        } else {
            echo "Failed to delete appointment.";
        }
    } else {
        echo "Invalid appointment ID.";
    }
}
