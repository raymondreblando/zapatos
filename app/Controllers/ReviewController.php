<?php

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;
use stdClass;

class ReviewController
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(string $shoeId): array
  {
    $selectReviewQuery = 'SELECT *, SUM(r.rating) AS review_rating FROM `reviews` r LEFT JOIN `accounts` a ON r.account_id=a.account_id WHERE r.shoe_id = ? ORDER BY r.id DESC';
    $this->helper->query($selectReviewQuery, [$shoeId]);

    return $this->helper->fetchAll();
  }

  public function showLatestReviews(): array
  {
    $selectLatestReviewQuery = 'SELECT * FROM `reviews` r LEFT JOIN `accounts` a ON r.account_id=a.account_id ORDER BY r.id DESC LIMIT 8';
    $this->helper->query($selectLatestReviewQuery);

    return $this->helper->fetchAll();
  }

  public function insert(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'Select rating and enter your review');
    }

    $isShoeExistQuery = 'SELECT * FROM `shoes` WHERE `shoe_id` = ?';
    $this->helper->query($isShoeExistQuery, [$payload['sid']]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $selectLatestOrderQuery = 'SELECT * FROM `orders` WHERE `account_id` = ? ORDER BY `id` DESC';
    $this->helper->query($selectLatestOrderQuery, [$_SESSION['uid']]);
    $orderDetails = $this->helper->fetch();

    $isReviewExistQuery = 'SELECT * FROM `reviews` WHERE `account_id` = ? AND `order_id` = ?';
    $this->helper->query($isReviewExistQuery, [$_SESSION['uid'], $orderDetails->order_id]);

    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'You have already posted your review');
    }

    $reviewId = Utilities::uuid();
    $currentDate = Utilities::getCurrentDate();

    $insertReviewParams = [
      $reviewId,
      $_SESSION['uid'],
      $orderDetails->order_id,
      $payload['sid'],
      $payload['rating'],
      $payload['review'],
      $currentDate
    ];

    $insertReviewQuery = 'INSERT INTO `reviews` (`review_id`, `account_id`, `order_id`, `shoe_id`, `rating`, `content`, `date_created`) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $this->helper->query($insertReviewQuery, $insertReviewParams);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Review cannot be posted');
    }

    return Utilities::response('success', 'Review was posted successfully');
  }
}