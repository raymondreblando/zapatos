<?php

namespace App\Utils;

use \Gumlet\ImageResize;

class FileUpload
{
  private $image;
  private $file;
  private $path;
  private $index = null;

  public function __construct(string $path)
  {
    $this->path = $path;
  }

  public function setFile(array $file, int $index = null): void
  {
    $this->file = $file;
    $this->index = $index;
  }

  public function getExtension(): string
  {
    if($this->index === null){
      $extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
    } else{
      $extension = pathinfo($this->file['name'][$this->index], PATHINFO_EXTENSION);
    }

    return strtolower($extension);
  }

  public function isUploading(): bool
  {
    if($this->index === null){
      return $this->file['size'] > 0 ? true : false;
    }

    return $this->file['size'][$this->index] > 0 ? true : false;
  }

  public function isUploadSuccess(string $filename): bool
  {
    $tempFile = $this->index === null ? $this->file['tmp_name'] : $this->file['tmp_name'][$this->index];
    $this->image = new ImageResize($tempFile);
    $this->image->resizeToWidth(400);

    return $this->image->save($this->path.$filename) ? true : false;
  }
}