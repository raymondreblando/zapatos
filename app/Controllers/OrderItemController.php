<?php

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;

class OrderItemController
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(string $orderId): array
  {
    $selectOrderItemQuery = 'SELECT * FROM `orderred_items` o LEFT JOIN `shoes` s ON o.shoe_id=s.shoe_id LEFT JOIN `brands` b ON s.brand_id=b.brand_id LEFT JOIN `sizes` si ON o.size_id=si.size_id LEFT JOIN `colors` c ON o.color_id=c.color_id WHERE o.order_id = ?';
    $this->helper->query($selectOrderItemQuery, [$orderId]);

    return $this->helper->fetchAll();
  }

  public function showTopSelling(): array
  {
    $selectTopSellingQuery = 'SELECT *, SUM(oi.quantity) AS unit_sold FROM `orderred_items` oi LEFT JOIN `orders` o ON oi.order_id=o.order_id LEFT JOIN `shoes` s ON oi.shoe_id=s.shoe_id LEFT JOIN `brands` b ON s.brand_id=b.brand_id LEFT JOIN `sizes` si ON oi.size_id=si.size_id LEFT JOIN `colors` c ON oi.color_id=c.color_id WHERE o.order_status = ? GROUP BY oi.shoe_id ORDER BY `unit_sold` DESC LIMIT 5';
    $this->helper->query($selectTopSellingQuery, ['Delivered']);

    return $this->helper->fetchAll();
  }
}