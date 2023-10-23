<?php 

require_once __DIR__ . '/../../config/init.php';

use App\Utils\Utilities;

$months = Utilities::getMonths();
$montlySales = [];

foreach ($months as $month) {
  $formattedMonth = Utilities::formatDate($month, 'Y-m');
  $saleDetails = $orderController->getTotalSales($formattedMonth);
  $montlySales[] = isset($saleDetails->total_sales) ? $saleDetails->total_sales : 0;
}

echo json_encode($montlySales);