<?php

require_once '/var/www/html/vendor/autoload.php';

use Clients\ClientController;

$controller = new ClientController();

$controller->handleRequest();
