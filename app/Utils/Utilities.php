<?php

namespace App\Utils;

use Ramsey\Uuid\Uuid;
use DateTime;
use DateInterval;

class Utilities
{
  public static function sanitize(string $data): string
  {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
  }

  public static function uuid(): string
  {
    $uuid = Uuid::uuid4();
    return $uuid->toString();
  }

  public static function generateOrderNo(string $prefix): string
  {
    return $prefix . rand(time(), 999999999);
  }

  public static function formatNumber(int $sales): string
  {
    $saleStr = (string) $sales;

    if ($sales > 100000) {
      $formattedSale = substr($saleStr, 0, 3) . 'K';
    } elseif ($sales > 1000000) {
      $formattedSale = substr($saleStr, 0, 1) . '.' . substr($saleStr, 1, 1) . 'M';
    } else {
      $formattedSale = (string) number_format($sales);
    }

    return $formattedSale;
  }

  public static function calculatePercentage(int $value, int $total): string
  {;
    $percentage = ($value / $total) * 100;
    return number_format($percentage, 2) . '%';
  }

  public static function calculateReviewRating(int $value, int $total): float
  {
    return $value / $total;
  }

  public static function generateToken(): string
  {
    return bin2hex(openssl_random_pseudo_bytes(32));
  }

  public static function isTokenExpired(int $tokenTimestamp): bool
  {
    $expirationThreshold = 15 * 60;
    $currentTimestamp = time();
    $timeDifference = $currentTimestamp - $tokenTimestamp;

    return $timeDifference > $expirationThreshold ? true : false;
  }

  public static function hashPassword(string $password): string
  {
    return password_hash($password, PASSWORD_BCRYPT, [10]);
  }

  public static function isPasswordSecure(string $password): bool
  {
    $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/';
    return preg_match($pattern, $password) ? true : false;    
  }

  public static function isArrayValueEmpty(array $array): bool
  {
    $hasEmptyValue = false;
    foreach ($array as $value) {
      if (empty($value)) {
        $hasEmptyValue = true;
      }
    }
    return $hasEmptyValue;
  }

  public static function isArrayHasDuplicate(array $array): bool
  {
    $removeArrayDuplicates = array_unique($array);
    return count($array) !== count($removeArrayDuplicates) ? true : false;
  }

  public static function setDynamicClassname(string $needle, array $array, string $classname = 'active') : string
  {
    return in_array($needle, $array) ? $classname : ''; 
  }

  public static function formatDate(string $date, string $format): string
  {
    return date($format, strtotime($date));
  }

  public static function getCurrentDate(): string
  {
    $date = new DateTime('');
    return $date->format('Y-m-d H:i:s');
  }

  public static function getWeekInterval(): string
  {
    $currentDate = new DateTime();
    $currentDate->sub(new DateInterval('P2W'));
    return $currentDate->format('Y-m-d H:i:s');
  }

  public static function getMonths(string $year = null): array
  {
    $months = [];
    $targetYear = date('Y');

    if (isset($year)) {
      $targetYear = $year;
    }

    for ($month = 1; $month <= 12; $month++) {
      $date = new DateTime("$targetYear-$month");
      $yearAndMonth = $date->format('Y-m');
      $months[] = $yearAndMonth;
    }

    return $months;
  }

  public static function getDatesBetweenDates(string $startDate, string $endDate): array
  {
    $dates = array();
    $currentDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    while ($currentDate <= $endDate) {
      $dates[] = $currentDate->format('Y-m-d');
      $currentDate->modify('+1 day');
    }

    return $dates;
  }

  public static function response(string $type, string $message): string
  {
    return json_encode(
      array(
        'type' => $type,
        'message' => $message
      )
    );
  }

  public static function isAdmin(): bool
  {
    return isset($_SESSION['role']) AND $_SESSION['role'] == '23799f1d-6198-11ee-adae-a6ab66fec5e3' ? true : false;
  }

  public static function isCustomer(): bool
  {
    return isset($_SESSION['role']) AND $_SESSION['role'] == '2379acad-6198-11ee-adae-a6ab66fec5e3' ? true : false;
  }

  public static function isAccountUnderVerification(): void
  {
    if(isset($_SESSION['email_uid'])){
      header('Location: '.SYSTEM_URL.'email/verification');
      exit();
    }
  }

  public static function isAccountNotUnderVerification(): void
  {
    if(!isset($_SESSION['email_uid'])){
      header('Location: '.SYSTEM_URL.'signin');
      exit();
    }
  }

  public static function isAuthorize(): bool
  {
    return isset($_SESSION['uid']) AND isset($_SESSION['role']) ? true : false;
  }

  public static function redirectUnauthorize(): void
  {
    if(!isset($_SESSION['uid']) AND !isset($_SESSION['role'])){
      header('Location: '.SYSTEM_URL.'signin');
      exit();
    }
  }

  public static function redirectAuthorize(string $route): void
  {
    if(isset($_SESSION['uid']) AND isset($_SESSION['role'])){
      header('Location: '.SYSTEM_URL.''.$route.'');
      exit();
    }
  }
}