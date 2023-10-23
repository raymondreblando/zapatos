<?php 

require_once __DIR__ . '/../../config/init.php';

$chartDatas = [];
$brands = $brandController->show();

foreach ($brands as $brand) {
  $chartDatas['labels'][] = $brand->brand_name;
  $brandShoes = $shoeController->getShoesByBrand($brand->brand_id);
  $chartDatas['data'][] = count($brandShoes);
}

echo json_encode($chartDatas);