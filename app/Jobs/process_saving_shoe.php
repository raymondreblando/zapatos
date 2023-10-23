<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$payload = [];
$sizes = explode(',', $_POST['sizes']);
$colors = $_POST['colors'];

unset($_POST['sizes'], $_POST['colors']);

foreach($_POST as $key => $value){
  $payload[$key] = Utilities::sanitize($value);
}

foreach($sizes as $size){
  $payload['sizes'][] = Utilities::sanitize($size);
}

foreach($colors as $color){
  $payload['colors'][] = Utilities::sanitize($color);
}

echo $shoeController->insert($payload);