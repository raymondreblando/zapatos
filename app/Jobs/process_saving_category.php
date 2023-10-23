<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$payload = array();

$payload['category_name'] = Utilities::sanitize($_POST['category_name']);

echo $categoryController->insert($payload);