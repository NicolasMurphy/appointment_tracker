<?php

use Services\Service;
use Services\ServiceRepository;
use Database\Database;

require_once '/var/www/html/vendor/autoload.php';

$dbConnection = Database::getInstance()->getConnection();
$serviceRepo = new ServiceRepository($dbConnection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = ($_POST['code'] ?? '');
    $description = ($_POST['description'] ?? '');
    $billRate = $_POST['bill_rate'] ?? '';

    try {
        $service = new Service($code, $description, $billRate);

        if ($serviceRepo->save($service)) {
            header('Location: ./views/list-services.php');
            exit();
        } else {
            echo "Failed to create service.";
        }
    } catch (InvalidArgumentException $e) {
        echo "<p style='color:red;'>{$e->getMessage()}</p>";
    }
}
