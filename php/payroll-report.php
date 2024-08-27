<?php

require_once '/var/www/html/vendor/autoload.php';

use Reports\Payroll\PayrollController;

$controller = new PayrollController();
$controller->handleRequest();
