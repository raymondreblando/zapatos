<?php

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;
use stdClass;

class ColorController
{
  private $helper;

  public function __construct(DbHelper $helper = null)
  {
    $this->helper = $helper;
  }

  public function show(string $shoeId): array
  {
    $colorSelectQuery = 'SELECT * FROM `colors` WHERE `shoe_id` = ?';
    $this->helper->query($colorSelectQuery, [$shoeId]);
    return $this->helper->fetchAll();
  }

  public function showOne(string $shoeId): stdClass
  {
    $colorSelectQuery = 'SELECT * FROM `colors` WHERE `shoe_id` = ? LIMIT 1';
    $this->helper->query($colorSelectQuery, [$shoeId]);
    return $this->helper->fetch();
  }

  public function update(string $colorId): string
  {
    if (empty($colorId)) {
      return Utilities::response('error', 'An error occurred. Try again');
    }

    $isColorExistQuery = 'SELECT * FROM `colors` WHERE `color_id` = ?';
    $this->helper->query($isColorExistQuery, [$colorId]);
    $colorDetails = $this->helper->fetch();

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occurred. Try again');
    }

    $updateColorStatus = $colorDetails->color_status === 'Available' ? 'Unavailable' : 'Available';
    $updateColorStatusQuery = 'UPDATE `colors` SET `color_status` = ? WHERE `color_id` = ?';
    $this->helper->query($updateColorStatusQuery, [$updateColorStatus, $colorId]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occurred. Try again');
    }

    return Utilities::response('success', 'Color status changed successfully');
  }

  public function getUniqueColors(): array
  {
    $selectUniqueColorQuery = 'SELECT * FROM `colors` GROUP BY `color_hex`';
    $this->helper->query($selectUniqueColorQuery);

    return $this->helper->fetchAll();
  }
}