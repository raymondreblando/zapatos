<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$email = Utilities::sanitize($_POST['email']);
$currentDate = Utilities::getCurrentDate();

if (!empty($email)) {
  $isEmailExistQuery = 'SELECT * FROM `subscribers` WHERE `email` = ?';
  $helper->query($isEmailExistQuery, [$email]);
}

if (empty($email)) {
  echo Utilities::response('error', 'Provide your email address');
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo Utilities::response('error', 'Invalid email address');
} elseif ($helper->rowCount() > 0) {
  echo Utilities::response('error', 'Email already has been taken');
} else {
  $insertSubscriberQuery = 'INSERT INTO `subscribers` (`email`, `date_created`) VALUES (?, ?)';
  $helper->query($insertSubscriberQuery, [$email, $currentDate]);

  echo Utilities::response('success','Thankyou for subscribing to our newsletter');
}