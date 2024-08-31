<?php

require_once '/var/www/html/vendor/autoload.php';

use Appointments\AppointmentController;
use Appointments\AppointmentService;
use Appointments\AppointmentRepository;
use Clients\ClientService;
use Clients\ClientRepository;
use Caregivers\CaregiverService;
use Caregivers\CaregiverRepository;
use Services\ServiceService;
use Services\ServiceRepository;
use Database\Database;

$dbConnection = Database::getInstance()->getConnection();

$appointmentRepository = new AppointmentRepository($dbConnection);
$clientRepository = new ClientRepository($dbConnection);
$caregiverRepository = new CaregiverRepository($dbConnection);
$serviceRepository = new ServiceRepository($dbConnection);

$appointmentService = new AppointmentService($appointmentRepository);
$clientService = new ClientService($clientRepository);
$caregiverService = new CaregiverService($caregiverRepository);
$serviceService = new ServiceService($serviceRepository);

$controller = new AppointmentController(
    $appointmentService,
    $clientService,
    $caregiverService,
    $serviceService
);

$controller->handleRequest();
