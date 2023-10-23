<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$colorId = Utilities::sanitize($_POST['color_id']);

echo $colorController->update($colorId);