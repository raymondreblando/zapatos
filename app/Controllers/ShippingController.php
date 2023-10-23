<?php

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;
use stdClass;

class ShippingController
{
  private $helper;

  public function __construct(DbHelper $helper = null)
  {
    $this->helper = $helper;
  }

  public function show(string $accountId): array
  {
    $shippingSelectQuery = 'SELECT * FROM `shipping` s LEFT JOIN `accounts` a ON s.account_id=a.account_id WHERE s.account_id = ?';
    $this->helper->query($shippingSelectQuery, [$accountId]);
    return $this->helper->fetchAll();
  }

  public function showOne(string $accountId): stdClass
  {
    $shippingSelectQuery = 'SELECT * FROM `shipping` s LEFT JOIN `accounts` a ON s.account_id=a.account_id WHERE s.account_id = ?';
    $this->helper->query($shippingSelectQuery, [$accountId]);
    return $this->helper->fetch();
  }

  public function insert(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'Fill up all shipping information');
    }

    if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
      return Utilities::response('error', 'Invalid email address');
    }

    if (strlen($payload['contact_number']) < 11) {
      return Utilities::response('error', 'Input 11 digit number');
    }

    $isShippingDetailsAlreadySet = $this->show($_SESSION['uid']);

    $updateAccountQuery = 'UPDATE `accounts` SET `fullname` = ? WHERE `account_id` = ?';
    $this->helper->query($updateAccountQuery, [$payload['fullname'], $_SESSION['uid']]);

    if (count($isShippingDetailsAlreadySet) > 0) {
      $shippingDetailsParams = [
        $payload['contact_number'],
        $payload['email'],
        $payload['street'],
        $payload['zone'],
        $payload['barangay'],
        $payload['municipality'],
        $payload['province'],
        $payload['zip_code'],
        $_SESSION['uid']
      ];

      $shippingDetailsQuery = 'UPDATE `shipping` SET `contact_number` = ?, `email_address` = ?, `street` = ?, `zone` = ?, `barangay` = ?, `municipality` = ?, `province` = ?, `zip_code` = ? WHERE `account_id` = ?';
    } else {
      $shippingDetailsParams = [
        $_SESSION['uid'],
        $payload['contact_number'],
        $payload['email'],
        $payload['street'],
        $payload['zone'],
        $payload['barangay'],
        $payload['municipality'],
        $payload['province'],
        $payload['zip_code']
      ];

      $shippingDetailsQuery = 'INSERT INTO `shipping` (`account_id`, `contact_number`, `email_address`, `street`, `zone`, `barangay`, `municipality`, `province`, `zip_code`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
    }

    $this->helper->query($shippingDetailsQuery, $shippingDetailsParams);

    return Utilities::response('success', 'Shipping details was saved');
  }
}