<?php

use Caregivers\Caregiver;
use Caregivers\CaregiverRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null) {
    echo "Invalid caregiver ID.";
    exit();
}

$dbConnection = Database::getInstance()->getConnection();
$caregiverRepo = new CaregiverRepository($dbConnection);

$caregiverData = $caregiverRepo->fetchById($id);

if ($caregiverData === false) {
    echo "Caregiver not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $firstName = ($_POST['first_name'] ?? '');
    $lastName = ($_POST['last_name'] ?? '');
    $email = ($_POST['email'] ?? '');
    $phoneNumber = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $payRate = $_POST['pay_rate'] ?? '';

    if ($id === false || $id === null) {
        echo "Invalid caregiver ID.";
        exit();
    }

    try {
        $caregiver = new Caregiver($firstName, $lastName, $email, $phoneNumber, $address, $payRate);
        $caregiver->setId($id);

        if ($caregiverRepo->update($caregiver)) {
            header('Location: ../crud/views/list-caregivers.php');
            exit();
        } else {
            echo "Failed to update caregiver.";
        }
    } catch (InvalidArgumentException $e) {
        echo "<p style='color:red;'>{$e->getMessage()}</p>";
    }
}

include 'views/update-caregiver-form.php';
