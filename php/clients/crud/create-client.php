<?php
require __DIR__ . '/../Client.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbConnection = Database::getInstance()->getConnection();
    $client = new Client($dbConnection);

    $name = ($_POST['name'] ?? '');
    $email = ($_POST['email'] ?? '');
    $phoneNumber = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';

    $client->setDetails($name, $email, $phoneNumber, $address);

    if ($client->saveClient()) {
        header('Location: ./views/list-clients.php');
        exit();
    } else {
        echo "Failed to create client.";
    }
}
