<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$payload = array();

$payload['brand_name'] = Utilities::sanitize($_POST['brand_name']);

echo $brandController->insert($payload);