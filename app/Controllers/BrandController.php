<?php

namespace App\Controllers;

use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;
use stdClass;

class BrandController implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(string $filter = null): array
  {
    $this->helper->query('SELECT * FROM `brands` ORDER BY `id` DESC');
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass {}

  public function insert(array $payload): string
  {
    if (empty($payload['brand_name'])) {
      return Utilities::response('error', 'Enter brand name');
    }

    $this->helper->query('SELECT * FROM `brands` WHERE `brand_name` = ?', [$payload['brand_name']]);

    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Brand already added');
    }

    $brandId = Utilities::uuid();
    $currentDate = Utilities::getCurrentDate();

    $this->helper->query('INSERT INTO `brands` (`brand_id`, `brand_name`, `date_created`) VALUES (?, ?, ?)', [$brandId, $payload['brand_name'], $currentDate]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Brand cannot be saved');
    }

    return Utilities::response('success', 'Brand saved');
  }

  public function update(array $payload): string {}
}