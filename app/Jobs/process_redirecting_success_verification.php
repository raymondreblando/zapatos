<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

unset($_SESSION['email_uid']);

echo Utilities::response('success', SYSTEM_URL . 'signin');