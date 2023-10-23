<?php

namespace App\Controllers;

use App\Utils\DbHelper;

class SizeController
{
  private $helper;

  public function __construct(DbHelper $helper = null)
  {
    $this->helper = $helper;
  }

  public function show(string $shoeId): array
  {
    $selectSizeQuery = 'SELECT * FROM `sizes` WHERE `shoe_id` = ?';
    $this->helper->query($selectSizeQuery, [$shoeId]);
    return $this->helper->fetchAll();
  }
}