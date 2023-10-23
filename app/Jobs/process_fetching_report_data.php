<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

echo $reportController->generatePdfReport(Utilities::sanitize($_POST['report_id']));