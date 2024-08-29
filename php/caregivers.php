<?php

require_once '/var/www/html/vendor/autoload.php';

use Caregivers\CaregiverController;

$controller = new CaregiverController();

$controller->handleRequest();
