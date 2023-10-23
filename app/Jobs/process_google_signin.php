<?php

require_once __DIR__.'/../../config/init.php';

use Google\Client;
use App\Utils\Utilities;

$token = Utilities::sanitize($_POST['credential']);

echo $authProvider->googleSignIn($token);