<?php

namespace App\Controllers;

use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;
use stdClass;

class CustomerController implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(string $filter = null): array
  {
    $accountIdException = '1cdae304-6674-11ee-ae30-3a685d99e8bf';

    if (!empty($filter)) {
      $filter = $filter === 'Active' ? 1 : 0; 
      $selectCustomerParams = [$filter, $accountIdException];
      $selectCustomerQuery = 'SELECT * FROM `accounts` a LEFT JOIN `shipping` s ON a.account_id=s.account_id WHERE a.is_active = ? AND NOT a.account_id = ?';
    } else {
      $selectCustomerParams = [$accountIdException];
      $selectCustomerQuery = 'SELECT * FROM `accounts` a LEFT JOIN `shipping` s ON a.account_id=s.account_id WHERE NOT a.account_id = ?';
    }

    $this->helper->query($selectCustomerQuery, $selectCustomerParams);
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass {}

  public function insert(array $payload): string {}

  public function update(array $payload): string 
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $isAccountExistQuery = 'SELECT * FROM `accounts` WHERE `account_id` = ?';
    $this->helper->query($isAccountExistQuery, [$payload['account_id']]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $accountDetails = $this->helper->fetch();
    $accountStatus = $accountDetails->is_active == 1 ? 0 : 1;

    $updateAccountStatusQuery = 'UPDATE `accounts` SET `is_active` = ? WHERE `account_id` = ?';
    $this->helper->query($updateAccountStatusQuery, [$accountStatus, $payload['account_id']]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $message = $accountStatus == 0 ? 'deactivated' : 'activated';
    return Utilities::response('success', 'Account was '. $message);
  }
}