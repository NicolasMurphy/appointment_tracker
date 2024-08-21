<?php

use Appointments\Appointment;
use Database\Database;

require '/var/www/html/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null) {
        $dbConnection = Database::getInstance()->getConnection();
        $appointment = new Appointment($dbConnection);
        $appointment->setId($id);

        if ($appointment->deleteAppointment()) {
            header('Location: ../../../');
            exit();
        } else {
            echo "Failed to delete appointment.";
        }
    } else {
        echo "Invalid appointment ID.";
    }
}
