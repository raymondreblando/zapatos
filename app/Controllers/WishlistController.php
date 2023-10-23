<?php

namespace App\Controllers;

use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;
use stdClass;

class WishlistController implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(string $filter = null): array
  {
    $selectWishlistQuery = 'SELECT * FROM `wishlist` w LEFT JOIN `shoes` s ON w.shoe_id=s.shoe_id LEFT JOIN `brands` b ON s.brand_id=b.brand_id LEFT JOIN `categories` c ON s.category_id=c.category_id LEFT JOIN `sizes` si ON w.size_id=si.size_id LEFT JOIN `colors` co ON w.color_id=co.color_id WHERE w.account_id = ? ORDER BY w.id DESC';
    $this->helper->query($selectWishlistQuery, [$filter]);
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass
  {
    $selectWishlistQuery = 'SELECT * FROM `wishlist` WHERE `wishlist_id` = ?';
    $this->helper->query($selectWishlistQuery, [$id]);
    return $this->helper->fetch();
  }

  public function insert(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'Select a shoe color and size');
    }

    $isWishlistExistParams = [
      $_SESSION['uid'],
      $payload['shoe_id'],
      $payload['size_id'],
      $payload['color_id']
    ];

    $isWishlistExistQuery = 'SELECT * FROM `wishlist` WHERE `account_id` = ? AND `shoe_id` = ? AND `size_id` = ? AND `color_id` = ?';
    $this->helper->query($isWishlistExistQuery, $isWishlistExistParams);

    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Shoe already added in your wishlist');
    }

    $wishlistId = Utilities::uuid();
    $currentDate = Utilities::getCurrentDate();

    $insertWishlistParams = [
      $wishlistId,
      $_SESSION['uid'],
      $payload['shoe_id'],
      $payload['size_id'],
      $payload['color_id'],
      $currentDate
    ];

    $insertWishlistQuery = 'INSERT INTO `wishlist` (`wishlist_id`, `account_id`, `shoe_id`, `size_id`, `color_id`, `date_added`) VALUES (?, ?, ?, ?, ?, ?)';
    $this->helper->query($insertWishlistQuery, $insertWishlistParams);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Shoe cannot be added');
    }

    return Utilities::response('success', 'Shoe was added to wishlist');
  }

  public function update(array $payload): string {}

  public function delete(string $id): string
  {
    if (empty($id)) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $wishlistData = (array) $this->showOne($id);

    if (count($wishlistData) < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $deleteWishlistQuery = 'DELETE FROM `wishlist` WHERE `wishlist_id` = ?';
    $this->helper->query($deleteWishlistQuery, [$id]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Shoe cannot be deleted');
    }

    return Utilities::response('success', 'Shoe was deleted in your wishlist');
  }

  public function isShoeInWishlist(string $shoeId): bool
  {
    $isShoeWishlistExistQuery = 'SELECT * FROM `wishlist` WHERE `shoe_id` = ? AND `account_id` = ?';
    $this->helper->query($isShoeWishlistExistQuery, [$shoeId, $_SESSION['uid']]);
    
    return $this->helper->rowCount() > 0 ? true : false;
  }
}