<?php

use Caregivers\Caregiver;
use Caregivers\CaregiverRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$dbConnection = Database::getInstance()->getConnection();
$caregiverRepo = new CaregiverRepository($dbConnection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = ($_POST['first_name'] ?? '');
    $lastName = ($_POST['last_name'] ?? '');
    $email = ($_POST['email'] ?? '');
    $phoneNumber = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $payRate = $_POST['pay_rate'] ?? '';

    try {
        $caregiver = new Caregiver($firstName, $lastName, $email, $phoneNumber, $address, $payRate);

        if ($caregiverRepo->save($caregiver)) {
            header('Location: ./views/list-caregivers.php');
            exit();
        } else {
            echo "Failed to create caregiver.";
        }
    } catch (InvalidArgumentException $e) {
        echo "<p style='color:red;'>{$e->getMessage()}</p>";
    }
}
