<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$colorId = Utilities::sanitize($_POST['color_id']);
$shoeImages = $shoeImageController->show($colorId);

echo Utilities::response('success', json_encode($shoeImages));