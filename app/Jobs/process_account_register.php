<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$payload = array();

foreach ($_POST as $key => $value) {
  $payload[$key] = Utilities::sanitize($value);
}

echo $authProvider->register($payload);