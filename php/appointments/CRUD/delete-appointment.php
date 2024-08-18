<?php
require __DIR__ . '/../Appointment.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null) {
        $db = Database::getInstance();
        $appointment = new Appointment($db);
        $appointment->setId($id);

        if ($appointment->delete()) {
            header('Location: ../../../');
            exit();
        } else {
            echo "Failed to delete appointment.";
        }
    } else {
        echo "Invalid appointment ID.";
    }
}
