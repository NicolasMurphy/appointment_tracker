<?php

use Clients\Client;
use Clients\ClientRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null) {
    echo "Invalid client ID.";
    exit();
}

$dbConnection = Database::getInstance()->getConnection();
$clientRepo = new ClientRepository($dbConnection);

$clientData = $clientRepo->fetchById($id);

if ($clientData === false) {
    echo "Client not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $firstName = ($_POST['first_name'] ?? '');
    $lastName = ($_POST['last_name'] ?? '');
    $email = ($_POST['email'] ?? '');
    $phoneNumber = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';

    if ($id === false || $id === null) {
        echo "Invalid client ID.";
        exit();
    }

    try {
        $client = new Client($firstName, $lastName, $email, $phoneNumber, $address);
        $client->setId($id);

        if ($clientRepo->update($client)) {
            header('Location: ../crud/views/list-clients.php');
            exit();
        } else {
            echo "Failed to update client.";
        }
    } catch (InvalidArgumentException $e) {
        echo "<p style='color:red;'>{$e->getMessage()}</p>";
    }
}

include 'views/update-client-form.php';
