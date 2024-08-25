<?php
use Appointments\AppointmentRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$dbConnection = Database::getInstance()->getConnection();
$appointmentRepo = new AppointmentRepository($dbConnection);

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$verified = filter_input(INPUT_POST, 'verified', FILTER_VALIDATE_BOOLEAN);

if ($id !== false && $id !== null) {
    $appointmentRepo->updateVerificationStatus($id, $verified);
    header('Location: ../../../../');
    exit();
} else {
    echo "Invalid appointment ID.";
}
