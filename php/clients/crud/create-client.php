<?php

use Clients\Client;
use Clients\ClientRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$dbConnection = Database::getInstance()->getConnection();
$clientRepo = new ClientRepository($dbConnection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = ($_POST['first_name'] ?? '');
    $lastName = ($_POST['last_name'] ?? '');
    $email = ($_POST['email'] ?? '');
    $phoneNumber = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';

    try {
        $client = new Client($firstName, $lastName, $email, $phoneNumber, $address);

        if ($clientRepo->save($client)) {
            header('Location: ./views/list-clients.php');
            exit();
        } else {
            echo "Failed to create client.";
        }
    } catch (InvalidArgumentException $e) {
        if ($e->getMessage() === "Invalid phone number format.") {
            echo "<p style='color:red;'>The phone number you entered is invalid. Please use a valid format.</p>";
        }
    }
}
