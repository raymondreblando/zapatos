<?php

namespace App\Controllers;

use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;
use App\Utils\FileUpload;
use App\Utils\Email;
use stdClass;

class ShoeController extends FileUpload implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    parent::__construct('../../uploads/shoes/');
    $this->helper = $helper;
  }

  public function show(string $filter = null): array
  {
    $selectParams = [];

    if (!empty($filter) && $filter === 'New Arrival') {
      $currentDate = Utilities::getCurrentDate();
      $lastTwoWeekDate = Utilities::getWeekInterval();

      array_push($selectParams, $lastTwoWeekDate, $currentDate);
      $selectShoeQuery = 'SELECT * FROM `shoes` s LEFT JOIN `brands` b ON s.brand_id=b.brand_id LEFT JOIN `categories` c ON s.category_id=c.category_id WHERE s.date_created BETWEEN ? AND ? ORDER BY s.id DESC';
    } elseif (!empty($filter) && $filter === 'Top Selling') {
      $selectShoeQuery = 'SELECT *, SUM(oi.quantity) as order_total FROM `shoes` s LEFT JOIN `orderred_items` oi ON s.shoe_id=oi.shoe_id GROUP BY s.shoe_id ORDER BY `order_total` DESC';
    } elseif (!empty($filter) && $filter !== 'New Arrival') {
      array_push($selectParams, $filter);
      $selectShoeQuery = 'SELECT * FROM `shoes` s LEFT JOIN `brands` b ON s.brand_id=b.brand_id LEFT JOIN `categories` c ON s.category_id=c.category_id WHERE s.shoe_categorize_as = ? ORDER BY s.id DESC';
    } else {
      $selectShoeQuery = 'SELECT * FROM `shoes` s LEFT JOIN `brands` b ON s.brand_id=b.brand_id LEFT JOIN `categories` c ON s.category_id=c.category_id ORDER BY s.id DESC';
    }

    $this->helper->query($selectShoeQuery, $selectParams);
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass
  {
    $selectShoeQuery = 'SELECT * FROM `shoes` s LEFT JOIN `brands` b ON s.brand_id=b.brand_id LEFT JOIN `categories` c ON s.category_id=c.category_id WHERE s.shoe_id = ?';
    $this->helper->query($selectShoeQuery, [$id]);
    return $this->helper->fetch();
  }

  public function insert(array $payload): string
  {
    $shoeId = Utilities::uuid();
    $currentDate = Utilities::getCurrentDate();
    $sizes = $payload['sizes'];
    $colors = $payload['colors'];

    unset($payload['sizes'], $payload['colors']);

    if (Utilities::isArrayValueEmpty($payload)){
      return Utilities::response('error', 'Fill up all shoe information');
    }

    if (Utilities::isArrayValueEmpty($sizes)){
      return Utilities::response('error', 'Select shoe size');
    }

    if (Utilities::isArrayValueEmpty($colors)){
      return Utilities::response('error', 'Enter shoe color');
    }

    if(Utilities::isArrayHasDuplicate($colors)){
      return Utilities::response('error', 'There are color duplicates');
    }

    $isShoeExistQuery = 'SELECT * FROM `shoes` WHERE `shoe_name` = ?';
    $this->helper->query($isShoeExistQuery, [$payload['shoe_name']]);

    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Shoe already added');
    }

    $this->helper->startTransaction();

    $insertShoeParams = [
      $shoeId, 
      $payload['shoe_name'], 
      $payload['price'], 
      $payload['stocks'], 
      $payload['categorize_as'], 
      $payload['brand'], 
      $payload['category'], 
      $payload['discount'], 
      $payload['description'], 
      $currentDate
    ];

    $insertShoeQuery = 'INSERT INTO `shoes` (`shoe_id`, `shoe_name`, `shoe_price`, `shoe_stocks`, `shoe_categorize_as`, `brand_id`, `category_id`, `shoe_discount`, `shoe_description`, `date_created`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $this->helper->query($insertShoeQuery, $insertShoeParams);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Shoe cannot be added');
    }

    foreach ($sizes as $size) {
      $sizeId = Utilities::uuid();

      $insertSizeParams = [$sizeId, $shoeId, $size, $currentDate];
      $insertSizeQuery = 'INSERT INTO `sizes` (`size_id`, `shoe_id`, `size`, `date_created`) VALUES (?, ?, ?, ?)';
      $this->helper->query($insertSizeQuery, $insertSizeParams);

      if ($this->helper->rowCount() < 1) {
        $this->helper->rollback();
        return Utilities::response('error', 'An error occurred');
      }
    }

    foreach ($colors as $index => $color) {
      $colorId = Utilities::uuid();

      $insertColorParams = [$colorId, $shoeId, $color, $currentDate];
      $insertColorQuery = 'INSERT INTO `colors` (`color_id`, `shoe_id`, `color_hex`, `date_created`) VALUES (?, ?, ?, ?)';
      $this->helper->query($insertColorQuery, $insertColorParams);

      if ($this->helper->rowCount() < 1) {
        $this->helper>rollback();
        return Utilities::response('error', 'An error occurred');
      }

      if ($index === 0) {
        $totalImageUploads = count($_FILES['shoe_image']['name']);
        for ($shoeImageIdex = 0; $shoeImageIdex < $totalImageUploads; $shoeImageIdex++) {
          $this->setFile($_FILES['shoe_image'], $shoeImageIdex);
    
          if (!$this->isUploading()) {
            $this->helper->rollback();
            return Utilities::response('error', 'Upload shoe images');
          }
    
          $shoeImageId = Utilities::uuid();
          $insertShoeImageQuery = 'INSERT INTO `shoe_image` (`shoe_image_id`, `color_id`, `date_created`) VALUES (?, ?, ?)';
          $this->helper->query($insertShoeImageQuery, [$shoeImageId, $colorId, $currentDate]);
          
          $filename = $shoeImageId.'.png';
          if (!$this->isUploadSuccess($filename)) {
            $this->helper->rollback();
            return Utilities::response('error', 'An error occurred');
          }
        }
      }
    }

    $this->helper->commit();
    return Utilities::response('success', 'Shoe was added');
  }

  public function update(array $payload): string
  {
    $sizes = $payload['sizes'];
    $colors = $payload['colors'];

    unset($payload['sizes'], $payload['colors']);

    if (Utilities::isArrayValueEmpty($payload)){
      return Utilities::response('error', 'Fill up all shoe information');
    }

    if (Utilities::isArrayValueEmpty($sizes)){
      return Utilities::response('error', 'Select shoe size');
    }

    if (Utilities::isArrayValueEmpty($colors)){
      return Utilities::response('error', 'Enter shoe color');
    }

    if(Utilities::isArrayHasDuplicate($colors)){
      return Utilities::response('error', 'There are color duplicates');
    }

    $isShoeExistQuery = 'SELECT * FROM `shoes` WHERE NOT `shoe_id` = ? AND `shoe_name` = ?';
    $this->helper->query($isShoeExistQuery, [$payload['shoe_id'], $payload['shoe_name']]);

    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Shoe already added');
    }

    $this->helper->startTransaction();

    $updateShoeParams = [
      $payload['shoe_name'], 
      $payload['price'], 
      $payload['stocks'], 
      $payload['categorize_as'], 
      $payload['brand'], 
      $payload['category'], 
      $payload['discount'], 
      $payload['description'], 
      $payload['shoe_id']
    ];

    $updateShoeQuery = 'UPDATE `shoes` SET `shoe_name` = ?, `shoe_price` = ?, `shoe_stocks` = ?, `shoe_categorize_as` = ?, `brand_id` = ?, `category_id` = ?, `shoe_discount` = ?, `shoe_description` = ? WHERE `shoe_id` = ?';
    $this->helper->query($updateShoeQuery, $updateShoeParams);

    $selectSizeQuery = 'SELECT * FROM `sizes` WHERE `shoe_id` = ? AND `size_status` = ?';
    $this->helper->query($selectSizeQuery, [$payload['shoe_id'], 1]);
    $shoeSizes = array_column($this->helper->fetchAll(), 'size_id');

    $sizeDifferences = array_diff($sizes, $shoeSizes);

    if (count($sizeDifferences) > 0) {
      foreach ($sizeDifferences as $sizeId) {
        $selectSizeDetailsQuery = 'SELECT `size_status` FROM `sizes` WHERE `size_id` = ?';
        $this->helper->query($selectSizeDetailsQuery, [$sizeId]);
        $sizeStatus = $this->helper->fetch();
        $newSizeStatus = $sizeStatus->size_status === 0 ? 1 : 0;

        $updateSizeStatusQuery = 'UPDATE `sizes` SET `size_status` = ? WHERE `size_id` = ?';
        $this->helper->query($updateSizeStatusQuery, [$newSizeStatus, $sizeId]);

        if ($this->helper->rowCount() < 1) {
          $this->helper->rollback();
          return Utilities::response('error', 'An error occurred. Try again 1');
        }
      }
    }

    $selectColorQuery = 'SELECT * FROM `colors` WHERE `shoe_id` = ?';
    $this->helper->query($selectColorQuery, [$payload['shoe_id']]);
    $shoeColors = array_column($this->helper->fetchAll(), 'color_hex');

    $colorDifferences = array_diff($colors, $shoeColors);

    if (count($colorDifferences) > 0) {
      $currentDate = Utilities::getCurrentDate();

      foreach ($colorDifferences as $newColor) {
        $colorId = Utilities::uuid();
  
        $insertColorParams = [$colorId, $payload['shoe_id'], $newColor, $currentDate];
        $insertColorQuery = 'INSERT INTO `colors` (`color_id`, `shoe_id`, `color_hex`, `date_created`) VALUES (?, ?, ?, ?)';
        $this->helper->query($insertColorQuery, $insertColorParams);

        if ($this->helper->rowCount() < 1) {
          $this->helper>rollback();
          return Utilities::response('error', 'An error occurred. Try again 2');
        }
      }
    }

    $this->helper->commit();
    return Utilities::response('success', 'Shoe details updated successfully');
  }

  public function getShoesByBrand(string $brandId): array
  {
    $selectShoeByBrandQuery = 'SELECT * FROM `shoes` WHERE `brand_id` = ?';
    $this->helper->query($selectShoeByBrandQuery, [$brandId]);
    return $this->helper->fetchAll();
  }
}