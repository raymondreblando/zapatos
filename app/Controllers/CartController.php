<?php

namespace App\Controllers;

use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;
use stdClass;

class CartController implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(string $filter = null): array
  {
    $selectCartItemQuery = 'SELECT * FROM `cart` c LEFT JOIN `shoes` s On c.shoe_id=s.shoe_id LEFT JOIN `sizes` si ON c.size_id=si.size_id LEFT JOIN `colors` co ON c.color_id=co.color_id WHERE c.account_id = ?';
    $this->helper->query($selectCartItemQuery, [$filter]);
    
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass 
  {
    $selectCartItemQuery = 'SELECT * FROM `cart` WHERE `cart_id`= ?';
    $this->helper->query($selectCartItemQuery, [$id]);
    return $this->helper->fetch();
  }

  public function insert(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'Select shoe color and size');
    }

    $isCartItemExistParams = [
      $payload['shoe_id'],
      $payload['size_id'],
      $payload['color_id'],
      $_SESSION['uid']
    ];

    $isCartItemExistQuery = 'SELECT * FROM `cart` WHERE `shoe_id` = ? AND `size_id` = ? AND `color_id` = ? AND `account_id` = ?';
    $this->helper->query($isCartItemExistQuery, $isCartItemExistParams);

    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Shoe already added to cart');
    }

    $selectShoeQuery = 'SELECT * FROM `shoes` WHERE `shoe_id`= ?';
    $this->helper->query($selectShoeQuery, [$payload['shoe_id']]);
    $shoeDetails = $this->helper->fetch();

    $cartId = Utilities::uuid();
    $currentDate = Utilities::getCurrentDate();

    $insertCartItemParams = [
      $cartId, 
      $payload['shoe_id'],
      $_SESSION['uid'],
      $payload['size_id'],
      $payload['color_id'],
      1,
      $shoeDetails->shoe_price,
      $currentDate
    ];

    $insertCartItemQuery = 'INSERT INTO `cart` (`cart_id`, `shoe_id`, `account_id`, `size_id`, `color_id`, `quantity`, `amount`, `date_added`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $this->helper->query($insertCartItemQuery, $insertCartItemParams);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    return Utilities::response('success', 'Shoe was added to cart');
  }

  public function update(array $payload): string 
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $isCartItemExist = (array) $this->showOne($payload['cart_id']);

    if (count($isCartItemExist) < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $cartItemDetails = $this->showOne($payload['cart_id']);
    $updateCartItemParams = [];

    if ($payload['type'] === 'minus' && $cartItemDetails->quantity === 1) {
      $updateCartItemQuery = 'DELETE FROM `cart` WHERE `cart_id` = ?';
      array_push($updateCartItemParams, $payload['cart_id']);
    } elseif ($payload['type'] === 'minus' && $cartItemDetails->quantity > 1) {
      $updateCartItemQuery = 'UPDATE `cart` SET `quantity` = ? WHERE `cart_id` = ?';
      $newQuantity = $cartItemDetails->quantity - 1;
      array_push($updateCartItemParams, $newQuantity, $payload['cart_id']);
    } else {
      $updateCartItemQuery = 'UPDATE `cart` SET `quantity` = ? WHERE `cart_id` = ?';
      $newQuantity = $cartItemDetails->quantity + 1;
      array_push($updateCartItemParams, $newQuantity, $payload['cart_id']);
    }

    $this->helper->query($updateCartItemQuery, $updateCartItemParams);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    return Utilities::response('success', $newQuantity);
  }
}