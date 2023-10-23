<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = isset($type) ? ucwords(str_replace('-', ' ', $type)) : 'Shoes';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';

  
?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content">
        <div class="main__content-header">
          <div>
            <h1 class="main__content-heading">Shoe Products</h1>
            <p class="main__content-subheading">Manage shoe products.</p>
          </div>

          <a href="<?= SYSTEM_URL . 'shoe/add' ?>" class="main__create">
            <i class="ri-add-line"></i>
            <p>Add New</p>
          </a>
        </div>

        <div class="main__filter-wrapper">
          <div class="main__tabs">
            <a href="<?= SYSTEM_URL . 'admin/shoes/' ?>" class="<?= Utilities::setDynamicClassname($title, ['Shoes']) ?>">Shoes</a>
            <a href="<?= SYSTEM_URL . 'admin/shoes/new-arrival' ?>" class="<?= Utilities::setDynamicClassname($title, ['New Arrival']) ?>">New Arrivals</a>
            <a href="<?= SYSTEM_URL . 'admin/shoes/top-selling' ?>" class="<?= Utilities::setDynamicClassname($title, ['Top Selling']) ?>">Top Selling</a>
          </div>

          <div class="select-group">
            <div class="custom-select">
              <select class="select-filter" data-type="brand">
                <option value="">All Brands</option>

                <?php foreach($brandController->show() as $brand): ?>

                  <option value="<?= $brand->brand_id ?>"><?= $brand->brand_name ?></option>

                <?php endforeach ?>

              </select>
            </div>

            <div class="custom-select">
              <select class="select-filter" data-type="category">
                <option value="">All Category</option>

                <?php foreach($categoryController->show() as $category): ?>

                  <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>

                <?php endforeach ?>

              </select>
            </div>
          </div>
        </div>

        <div class="main__grid-cols-6">

          <?php  
            $cardPlaceholderCount = 12;
            $shoes = $shoeController->show();
            $totalShoeRecordCount = count($shoes);
            $maxShoeRecordCount = $totalShoeRecordCount > $cardPlaceholderCount ? $totalShoeRecordCount : $cardPlaceholderCount;

            for ($index = 0; $index < $maxShoeRecordCount; $index++) :
          ?>

              <?php 
                if (isset($shoes[$index])) : 
                  $shoeMainColor = $colorController->showOne($shoes[$index]->shoe_id);
                  $shoeMainImage = $shoeImageController->showOne($shoeMainColor->color_id);
              ?>

                <div class="main__shoe-card search-area">
                  <div class="main__shoe-image">
                    <a href="<?= SYSTEM_URL . 'shoe/update/' . $shoes[$index]->shoe_id ?>"><i class="ri-pencil-fill"></i></a>
                    <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeMainImage->shoe_image_id . $shoeMainImage->extension ?>" alt="<?= $shoes[$index]->shoe_name ?>">
                  </div>
      
                  <p class="main__shoe-name finder4"><?= $shoes[$index]->shoe_name ?></p>
      
                  <div class="main__brand-stocks">
                    <p class="finder1" style="display: none"><?= $shoes[$index]->brand_id ?></p>
                    <p class="finder2" style="display: none"><?= $shoes[$index]->category_id ?></p>
                    <p class="finder3"><?= $shoes[$index]->category_name ?></p>
                    <span><?= $shoes[$index]->shoe_stocks ?> Left</span>
                  </div>
      
                  <div class="main__price-color">
                    <p>₱<?= number_format($shoes[$index]->shoe_price) ?></p>
                    <div class="main__shoe-colors">

                      <?php 
                        $shoeAvailableColors = $colorController->show($shoes[$index]->shoe_id);
                        $shoeAvailableColorCount = count($shoeAvailableColors);
                        for ($colorIndex = 0; $colorIndex < 3;  $colorIndex++) :
                          if (isset($shoeAvailableColors[$colorIndex])) :
                      ?>

                      <span style="background-color: <?= $shoeAvailableColors[$colorIndex]->color_hex ?>"></span>

                      <?php 
                          endif;
                        endfor 
                      ?>

                      <?php if ($shoeAvailableColorCount > 3) : ?>

                        <span>+<?= $shoeAvailableColorCount - 3 ?></span>

                      <?php endif ?>

                    </div>
                  </div>
                </div>

              <?php 
                else : 
              ?>

                <div class="main__shoe-card">
                  <div class="main__shoe-image skeleton">
                    <div class="skeleton__circle"></div>
                  </div>
                
                  <div style="width: 100px; height: 10px; background-color: #f7f8fa; margin-bottom: 4px; border-radius: 100px;"></div>
                
                  <div class="main__brand-stocks">
                    <div style="width: 30px; height: 8px; background-color: #f7f8fa; border-radius: 100px;"></div>
                    <div style="width: 30px; height: 8px; background-color: #f7f8fa; border-radius: 100px;"></div>
                  </div>
                
                  <div class="main__price-color">
                    <div style="width: 45px; height: 10px; background-color: #f7f8fa; border-radius: 100px;"></div>
                    <div class="main__shoe-colors">
                      <span class="skeleton"></span>
                      <span class="skeleton"></span>
                      <span class="skeleton"></span>
                      <div style="width: 15px; height: 8px; background-color: #f7f8fa; border-radius: 100px;"></div>
                    </div>
                  </div>
                </div>

              <?php 
                endif 
              ?>

          <?php 
            endfor
          ?>
          
        </div>
      </div>
    </section>
  </main>

<?php require_once 'app/Views/partials/_script.php' ?>