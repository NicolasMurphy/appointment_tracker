<?php
require __DIR__ . '/../Client.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbConnection = Database::getInstance()->getConnection();
    $client = new Client($dbConnection);

    $firstName = ($_POST['first_name'] ?? '');
    $lastName = ($_POST['last_name'] ?? '');
    $email = ($_POST['email'] ?? '');
    $phoneNumber = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';

    $client->setDetails($firstName, $lastName, $email, $phoneNumber, $address);

    if ($client->saveClient()) {
        header('Location: ./views/list-clients.php');
        exit();
    } else {
        echo "Failed to create client.";
    }
}
