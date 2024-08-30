<?php

require_once '/var/www/html/vendor/autoload.php';

use Appointments\AppointmentController;

$controller = new AppointmentController();
$controller->handleRequest();
