<?php

namespace App\Controllers;

use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;
use stdClass;

class CategoryController implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(string $filter = null): array
  {
    $this->helper->query('SELECT * FROM `categories` ORDER BY `id` DESC');
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass {}

  public function insert(array $payload): string
  {
    if (empty($payload['category_name'])) {
      return Utilities::response('error', 'Enter category name');
    }

    $this->helper->query('SELECT * FROM `categories` WHERE `category_name` = ?', [$payload['category_name']]);

    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Category already added');
    }

    $categoryId = Utilities::uuid();
    $currentDate = Utilities::getCurrentDate();

    $this->helper->query('INSERT INTO `categories` (`category_id`, `category_name`, `date_created`) VALUES (?, ?, ?)', [$categoryId, $payload['category_name'], $currentDate]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Category cannot be saved');
    }

    return Utilities::response('success', 'Category saved');
  }

  public function update(array $payload): string {}
}