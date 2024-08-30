<?php

require_once '/var/www/html/vendor/autoload.php';

use Services\ServiceController;

$controller = new ServiceController();

$controller->handleRequest();
