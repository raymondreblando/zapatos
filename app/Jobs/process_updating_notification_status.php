<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

echo $notificationController->update(Utilities::sanitize($_POST['notification_id']));