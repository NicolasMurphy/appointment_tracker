<?php

use Services\Service;
use Services\ServiceRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null) {
    echo "Invalid service ID.";
    exit();
}

$dbConnection = Database::getInstance()->getConnection();
$serviceRepo = new ServiceRepository($dbConnection);

$serviceData = $serviceRepo->fetchById($id);

if ($serviceData === false) {
    echo "Service not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $code = ($_POST['code'] ?? '');
    $description = ($_POST['description'] ?? '');
    $billRate = $_POST['bill_rate'] ?? '';

    if ($id === false || $id === null) {
        echo "Invalid service ID.";
        exit();
    }

    try {
        $service = new Service($code, $description, $billRate);
        $service->setId($id);

        if ($serviceRepo->update($service)) {
            header('Location: ../crud/views/list-services.php');
            exit();
        } else {
            echo "Failed to update service.";
        }
    } catch (InvalidArgumentException $e) {
        echo "<p style='color:red;'>{$e->getMessage()}</p>";
    }
}

include 'views/update-service-form.php';
