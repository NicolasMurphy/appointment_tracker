<?php

require_once '/var/www/html/vendor/autoload.php';

use Visits\VisitController;
use Visits\VisitService;
use Visits\VisitRepository;
use Clients\ClientService;
use Clients\ClientRepository;
use Caregivers\CaregiverService;
use Caregivers\CaregiverRepository;
use Services\ServiceService;
use Services\ServiceRepository;
use Database\Database;

$dbConnection = Database::getInstance()->getConnection();

$visitRepository = new VisitRepository($dbConnection);
$clientRepository = new ClientRepository($dbConnection);
$caregiverRepository = new CaregiverRepository($dbConnection);
$serviceRepository = new ServiceRepository($dbConnection);

$visitService = new VisitService($visitRepository);
$clientService = new ClientService($clientRepository);
$caregiverService = new CaregiverService($caregiverRepository);
$serviceService = new ServiceService($serviceRepository);

$controller = new VisitController(
    $visitService,
    $clientService,
    $caregiverService,
    $serviceService
);

$controller->handleRequest();
