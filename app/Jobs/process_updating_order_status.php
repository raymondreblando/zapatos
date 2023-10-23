<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$payload = [];

foreach ($_POST as $key => $value) {
  $payload[$key] = Utilities::sanitize($value);
}

echo $orderController->update($payload);