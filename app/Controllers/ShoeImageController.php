<?php

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;
use App\Utils\FileUpload;
use stdClass;

class ShoeImageController extends FileUpload
{
  private $helper;

  public function __construct(DbHelper $helper = null)
  {
    parent::__construct('../../uploads/shoes/');
    $this->helper = $helper;
  }

  public function show(string $colorId): array
  {
    $selectShoeImageQuery = 'SELECT * FROM `shoe_image` WHERE `color_id` = ?';
    $this->helper->query($selectShoeImageQuery, [$colorId]);
    return $this->helper->fetchAll();
  }

  public function showOne(string $colorId): stdClass
  {
    $selectShoeImageQuery = 'SELECT * FROM `shoe_image` WHERE `color_id` = ? LIMIT 1';
    $this->helper->query($selectShoeImageQuery, [$colorId]);
    return $this->helper->fetch();
  }

  public function insert(string $colorId): string
  {
    if (empty($colorId)) {
      return Utilities::response('error', 'An error occurred. Try again');
    }

    $this->helper->startTransaction();
    $currentDate = Utilities::getCurrentDate();
    $totalShoeImageUploads = count($_FILES['shoe_image']['name']);

    for ($uploadIndex = 0; $uploadIndex < $totalShoeImageUploads; $uploadIndex++) {
      $shoeImageId = Utilities::uuid();
      $this->setFile($_FILES['shoe_image'], $uploadIndex);

      if (!$this->isUploading()) {
        return Utilities::response('error', 'Upload shoe images');
      }

      $insertShoeImageQuery = 'INSERT INTO `shoe_image` (`shoe_image_id`, `color_id`, `date_created`) VALUES (?, ?, ?)';
      $this->helper->query($insertShoeImageQuery, [$shoeImageId, $colorId, $currentDate]);

      $filename = $shoeImageId.'.png';
      if (!$this->isUploadSuccess($filename)) {
        $this->helper->rollback();
        return Utilities::response('error', 'An error occur while uploading');
      }
    }

    $this->helper->commit();
    return Utilities::response('success', 'Shoe image uploaded successfully');
  }
}