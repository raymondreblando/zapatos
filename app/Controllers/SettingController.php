<?php

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;
use stdClass;

class SettingController
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(): stdClass
  {
    $selectSettingQuery = 'SELECT * FROM `settings`';
    $this->helper->query($selectSettingQuery);
    return $this->helper->fetch();
  }

  public function insert(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'Fill all of the required fields');
    }

    if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
      return Utilities::response('error', 'Invalid email address');
    }

    if (strlen($payload['contact_number']) < 11) {
      return Utilities::response('error', 'Input an 11 digit number');
    }

    $selectSettingQuery = 'SELECT * FROM `settings`';
    $this->helper->query($selectSettingQuery);

    $settingParams = [
      $payload['address'],
      $payload['email'],
      $payload['contact_number']
    ];

    if ($this->helper->rowCount() > 0) {
      $updateSettingQuery = 'UPDATE `settings` SET `address` = ?, `email` = ?, `contact_number` = ? WHERE `id` = ?';
      $this->helper->query($updateSettingQuery, [array_values($settingParams), 1]);
    } else {
      $insertSettingQuery = 'INSERT INTO `settings` (`address`, `email`, `contact_number`) VALUES (?, ?, ?)';
      $this->helper->query($insertSettingQuery, $settingParams);
    }

    return Utilities::response('success', 'Settings was saved successfully');
  }
}