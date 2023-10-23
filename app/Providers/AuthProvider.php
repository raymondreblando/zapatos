<?php

namespace App\Providers;

use Google\Client;
use App\Utils\Utilities;
use App\Utils\DbHelper;
use App\Utils\Email;

class AuthProvider extends Client
{
  private $helper;
  private $mailer;
  private $role_id = '2379acad-6198-11ee-adae-a6ab66fec5e3';

  public function __construct(DbHelper $helper)
  {
    parent::__construct(['client_id' => $_ENV['GOOGLE_CLIENT_ID']]);
    $this->helper = $helper;
    $this->mailer = new Email();
  }

  public function register(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'Fill up all required fields');
    }

    if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
      return Utilities::response('error', 'Invalid email address');
    }

    if ($payload['password'] !== $payload['confirm_password']) {
      return Utilities::response('error', 'Password not matched');
    }

    if (strlen($payload['password']) < 7) {
      return Utilities::response('error', 'Password length must be 8');
    }

    if (!Utilities::isPasswordSecure($payload['password'])) {
      return Utilities::response('error', 'Password must contain 1 uppercase, character, & number');
    }

    $isEmailExistQuery = 'SELECT * FROM `accounts` WHERE `email` = ?';
    $this->helper->query($isEmailExistQuery, [$payload['email']]);

    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Email already has been taken');
    }

    $accountId = Utilities::uuid();
    $currentDate = Utilities::getCurrentDate();
    $hashPassword = Utilities::hashPassword($payload['password']);

    $insertAccountParams = [
      $accountId,
      $payload['email'],
      $hashPassword,
      $this->role_id,
      $currentDate
    ];

    $this->helper->startTransaction();

    $insertAccountQuery = 'INSERT INTO `accounts` (`account_id`, `email`, `password`, `role_id`, `date_joined`) VALUES (?, ?, ?, ?, ?)';
    $this->helper->query($insertAccountQuery, $insertAccountParams);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occurred. Try again');
    }

    $token = Utilities::generateToken();
    $timestamp = time();

    $insertEmailVerificationParams = [
      $accountId,
      $token,
      $timestamp,
      $currentDate
    ];

    $insertEmailVerificationQuery = 'INSERT INTO `email_verify` (`account_id`, `token`, `timestamp`, `date_created`) VALUES (?, ?, ?, ?)';
    $this->helper->query($insertEmailVerificationQuery, $insertEmailVerificationParams);

    if ($this->helper->rowCount() < 1) {
      $this->helper->rollback();
      return Utilities::response('error', 'An error occurred. Try again');
    }

    ob_start();
    include '../../public/template/email.html';
    $emailContent = ob_get_clean();

    $verificationLink = $_ENV['SYSTEM_URL'] . 'verify/' . $token;
    $emailContent = str_replace('%VERIFYLINK%', $verificationLink, $emailContent);

    $emailParams = [
      'email' => $payload['email'],
      'fullname' => 'User',
      'subject' => 'Email Verification',
      'body' => $emailContent,
      'altbody' => 'Click this link to verify your email ' . $verificationLink 
    ];

    if (!$this->mailer->sendEmail($emailParams)) {
      $this->helper->rollback();
      return Utilities::response('error', 'An error occurred. Try again');
    }

    $_SESSION['email_uid'] = $accountId;

    $this->helper->commit();
    return Utilities::response('success', 'Account created successfully');
  }

  public function googleSignIn(string $token): void
  {
    if (empty($token)) {
      header('Location: '.SYSTEM_URL.'signin');
      exit();
    }

    $payload = $this->verifyIdToken($token);

    if (!$payload) {
      header('Location: '.SYSTEM_URL.'signin');
      exit();
    }

    $fullname = $payload['name'];
    $email = $payload['email'];
    $username = $payload['given_name'];

    $isAccountExistQuery = 'SELECT * FROM `accounts` WHERE `email` = ?';
    $this->helper->query($isAccountExistQuery, [$email]);

    if ($this->helper->rowCount() > 0) {
      $userData = $this->helper->fetch();
      $_SESSION['uid'] = $userData->account_id;
      $_SESSION['role'] = $userData->role_id;
    } else {
      $accountId = Utilities::uuid();
      $currentDate = Utilities::getCurrentDate();

      $insertAccountParams = [
        $accountId,
        $fullname,
        $username,
        $email,
        $this->role_id,
        1,
        $currentDate
      ];

      $insertAccountQuery = 'INSERT INTO `accounts` (`account_id`, `fullname`, `username`, `email`, `role_id`, `is_verified`, `date_joined`) VALUES (?, ?, ?, ?, ?, ?, ?)';
      $this->helper->query($insertAccountQuery, $insertAccountParams);

      if ($this->helper->rowCount() < 1){
        header('Location: '.SYSTEM_URL.'signin');
        exit();
      }

      $_SESSION['uid'] = $accountId;
      $_SESSION['role'] = $role_id;
    }

    header('Location: '.SYSTEM_URL.'shoes/');
    exit();
  }

  public function signIn(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'Fill up all required fields');
    }

    if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
      return Utilities::response('error', 'Invalid email address');
    }

    $isAccountExistQuery = 'SELECT * FROM `accounts` WHERE `email` = ?';
    $this->helper->query($isAccountExistQuery, [$payload['email']]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Invalid account credentials');
    }

    $accountData = $this->helper->fetch();

    if (!password_verify($payload['password'], $accountData->password)) {
      return Utilities::response('error', 'Incorrect account password');
    }

    if ($accountData->is_verified === 0) {
      return Utilities::response('error', 'Account not verified');
    }

    $_SESSION['uid'] = $accountData->account_id;
    $_SESSION['role'] = $accountData->role_id;

    if ($accountData->role_id === '') {
      $redirectUrl = 'dashboard';
    } else {
      $redirectUrl = 'shoes/';
    }

    return Utilities::response('success', SYSTEM_URL . $redirectUrl);
  }

  public function signOut(): void
  {
    session_destroy();
    header('Location: '.SYSTEM_URL.'signin');
    exit();
  }
}