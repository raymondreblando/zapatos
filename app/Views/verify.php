<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

Utilities::isAccountNotUnderVerification();

$verificationToken = Utilities::sanitize($token);

$isTokenExistQuery = 'SELECT * FROM `email_verify` e LEFT JOIN `accounts` a ON e.account_id=a.account_id WHERE e.token = ?';
$helper->query($isTokenExistQuery, [$verificationToken]);
$verificationDetails = $helper->fetch();

if ($verificationDetails->is_verified === 1) {
  header('Location: '.SYSTEM_URL.'signin');
  exit();
} elseif ($helper->rowCount() > 0 && !Utilities::isTokenExpired($verificationDetails->timestamp)) {
  $updateAccountStatusQuery = 'UPDATE `accounts` SET `is_verified` = ? WHERE `account_id` = ?';
  $helper->query($updateAccountStatusQuery, [1, $verificationDetails->account_id]);

  if ($helper->rowCount() > 0) {
    header('Location: '.SYSTEM_URL.'verification/success/'.$verificationToken.'');
    exit();
  } else {
    header('Location: '.SYSTEM_URL.'verification/error/'.$verificationToken.'');
    exit();
  }
} else {
  header('Location: '.SYSTEM_URL.'verification/error/'.$verificationToken.'');
  exit();
}