<?php

require_once '/var/www/html/vendor/autoload.php';

use Reports\Billing\BillingController;

$controller = new BillingController();
$controller->handleRequest();
