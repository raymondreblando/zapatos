<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  if (Utilities::isAdmin()) {
    Utilities::redirectAuthorize('dashboard');
  }
  
  $title = isset($type) ? ucwords(str_replace('-', ' ', $type)) : 'Shoes';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';
  
  $shoeParams = $title === 'Shoes' ? '' : $title;
  $shoes = $shoeController->show($shoeParams);

?>

  <main>

    <?php require_once 'app/Views/partials/_nav.php' ?>

    <div class="product-wrapper">
      <div class="product-wrapper__header">
        <p><?= $title === 'Shoes' ? 'Shoes' : $title . ' Shoes' ?></p>

        <div class="product-wrapper__filter-search">
          <div class="product-wrapper__searchbar">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/search.svg" alt="search">
            <input type="text" id="search-input" placeholder="Search" autocomplete="off">
          </div>
          <button type="button" class="product-wrapper__filter--btn">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/filter.svg" alt="filter">
          </button>
        </div>
      </div>

      <ul class="product-wrapper__brands">
        <li type="button">
          Nike
        </li>
        <li type="button">
          Adidas
        </li>
        <li type="button">
          Puma
        </li>
        <li type="button">
          Skechers
        </li>
        <li type="button">
          Fila
        </li>
      </ul>

      <div class="product-wrapper__products">
        <div class="product-wrapper__filters">
          <div class="product-wrapper__catalog">
            <div class="product-wrapper__catalog-header">
              <p>Brands</p>
              <button type="button"><i class="ri-arrow-down-s-line"></i></button>
            </div>
            <ul class="product-wrapper__list">

              <?php 
                $brands = $brandController->show();
                
                foreach ($brands as $brand) :
              ?>

                  <li type="button" class="brand-filter" data-value="<?= $brand->brand_id ?>">
                    <?= $brand->brand_name ?>
                  </li>

              <?php 
                endforeach
              ?>

            </ul>
          </div>

          <div class="product-wrapper__catalog">
            <div class="product-wrapper__catalog-header">
              <p>Category</p>
              <button type="button"><i class="ri-arrow-down-s-line"></i></button>
            </div>
            <ul class="product-wrapper__list">
              <?php 
                $categories = $categoryController->show();
                
                foreach ($categories as $category) :
              ?>

                  <li type="button" class="category-filter" data-value="<?= $category->category_id ?>">
                    <?= $category->category_name ?>
                  </li>

              <?php 
                endforeach
              ?>
              
            </ul>
          </div>

          <div class="product-wrapper__catalog">
            <div class="product-wrapper__catalog-header">
              <p>Gender</p>
              <button type="button"><i class="ri-arrow-down-s-line"></i></button>
            </div>

            <ul class="product-wrapper__brand-list">
              <button class="product-wrapper__checkbox gender-filter" data-value="Men">
                <div class="product-wrapper__checkbox-box"></div>
                <p>Men</p>
              </button>
              <button class="product-wrapper__checkbox gender-filter" data-value="Women">
                <div class="product-wrapper__checkbox-box"></div>
                <p>Women</p>
              </button>
              <button class="product-wrapper__checkbox gender-filter" data-value="Unisex">
                <div class="product-wrapper__checkbox-box"></div>
                <p>Unisex</p>
              </button>
            </ul>
          </div>

          <div class="product-wrapper__catalog">
            <div class="product-wrapper__catalog-header">
              <p>Shop By Price</p>
              <button type="button"><i class="ri-arrow-down-s-line"></i></button>
            </div>
            <ul class="product-wrapper__brand-list">
              <button class="product-wrapper__checkbox price-filter" data-value="0-3000">
                <div class="product-wrapper__checkbox-box"></div>
                <p>Under ₱3,000</p>
              </button>
              <button class="product-wrapper__checkbox price-filter" data-value="3000-6000">
                <div class="product-wrapper__checkbox-box"></div>
                <p>₱3,000 - ₱6,000</p>
              </button>
              <button class="product-wrapper__checkbox price-filter" data-value="6001-11000">
                <div class="product-wrapper__checkbox-box"></div>
                <p>₱6,001 - ₱11,000</p>
              </button>
              <button class="product-wrapper__checkbox price-filter" data-value="11001">
                <div class="product-wrapper__checkbox-box"></div>
                <p>Over ₱11,000</p>
              </button>
            </ul>
          </div>

          <div class="product-wrapper__catalog">
            <div class="product-wrapper__catalog-header">
              <p>Size</p>
              <button type="button"><i class="ri-arrow-down-s-line"></i></button>
            </div>
            
            <ul class="product-wrapper__size-list">
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="2">2</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="2.5">2.5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="3">3</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="3.5">3.5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="4">4</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="4.5">4.5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="5">5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="5.5">5.5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="6">6</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="6.5">6.5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="7">7</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="7.5">7.5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="8">8</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="8.5">8.5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="9">9</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="9.5">9.5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="10">10</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="10.5">10.5</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="11">11</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="12">12</li>
              <li type="button" class="product-wrapper__tickbox size-filter" data-value="13">13</li>
            </ul>
          </div>

          <div class="product-wrapper__catalog">
            <div class="product-wrapper__catalog-header">
              <p>Colours</p>
              <button type="button"><i class="ri-arrow-down-s-line"></i></button>
            </div>
            
            <ul class="product-wrapper__color-list">

              <?php
                $colors = $colorController->getUniqueColors();

                foreach ($colors as $color) :
              ?>

                  <button class="product-wrapper__radio color-filter" data-value="<?= $color->color_hex ?>">
                    <div class="product-wrapper__color" style="background-color: <?= $color->color_hex ?>">
                      <i class="ri-check-line"></i>
                    </div>
                  </button>

              <?php 
                endforeach;
              ?>
              
            </ul>
          </div>
        </div>

        <div class="product-wrapper__grid">

          <?php 
            $shoePlaceholderCount = 12;
            $shoeRecordCount = count($shoes);
            $maxShoeDisplayCount = $shoeRecordCount > $shoePlaceholderCount ? $shoeRecordCount : $shoePlaceholderCount;

            for ($shoeIndex = 0; $shoeIndex < $maxShoeDisplayCount; $shoeIndex++) :
              if (isset($shoes[$shoeIndex])) :
                $shoeSizeValues = '';
                $shoeColorHexValue = '';

                $shoeSizes = $sizeController->show($shoes[$shoeIndex]->shoe_id);

                foreach ($shoeSizes as $shoeSize) {
                  $shoeSizeValues .= $shoeSize->size.',';
                }

                $shoeColors = $colorController->show($shoes[$shoeIndex]->shoe_id);

                foreach ($shoeColors as $shoeColor) {
                  $shoeColorHexValue .= $shoeColor->color_hex.',';
                }

                $shoeMainImage = $shoeImageController->showOne($shoeColors[0]->color_id);
                $reviewRatings = $reviewController->show($shoes[$shoeIndex]->shoe_id);
                $totalRating = $reviewRatings[0]->review_rating ?? 0;
                $reviewCount = isset($reviewRatings[0]->review_id) ? count($reviewRatings) : 0;
                $finalRating = $totalRating > 0 ? Utilities::calculateReviewRating($totalRating, $reviewCount) : 0;
          ?>

                <div class="product-wrapper__card search-area">
                  <div class="product-wrapper__card-image">

                    <?php 
                      if (Utilities::isAuthorize()) :
                        $isShoeInWishlist = $wishlistController->isShoeInWishlist($shoes[$shoeIndex]->shoe_id);
                    ?>

                        <i type="button" class="<?= $isShoeInWishlist ? 'ri-heart-3-fill' : 'ri-heart-3-line' ?>"></i>
                        
                    <?php 
                      else :
                    ?>

                        <a href="<?= SYSTEM_URL . 'signin' ?>">
                          <i type="button" class="ri-heart-3-line" data-value="<?= $shoes[$shoeIndex]->shoe_id ?>"></i>
                        </a>

                    <?php 
                      endif
                    ?>

                    <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeMainImage->shoe_image_id . $shoeMainImage->extension ?>" alt="<?= $shoes[$shoeIndex]->shoe_name ?>">
                    <div class="product-wrapper__rating">
                      <i class="ri-star-fill"></i>
                      <p><?= $finalRating ?></p>
                    </div>
                  </div>
                  <div class="product-wrapper__details">
                    <div>
                      <a class="finder1" href="<?= SYSTEM_URL . 'shoe/details/' . $shoes[$shoeIndex]->shoe_id ?>"><?= $shoes[$shoeIndex]->shoe_name ?></a>
                      <p class="finder2 price-finder" data-value="<?= $shoes[$shoeIndex]->shoe_price ?>">₱<?= number_format($shoes[$shoeIndex]->shoe_price) ?></p>
                      <p class="brand-finder" data-value="<?= $shoes[$shoeIndex]->brand_id ?>" hidden></p>
                      <p class="gender-finder" data-value="<?= $shoes[$shoeIndex]->shoe_categorize_as ?>" hidden></p>
                      <p class="category-finder" data-value="<?= $shoes[$shoeIndex]->category_id ?>" hidden></p>
                      <div class="product-wrapper__card-colors">

                        <?php 
                          foreach ($shoeColors as $shoeColor) : 
                        ?>

                            <span class="product-wrapper__card-colors--btn" style="background-color: <?= $shoeColor->color_hex ?>"></span>

                        <?php 
                          endforeach
                        ?>

                        <p class="size-finder" data-value="<?=  $shoeSizeValues ?>" hidden></p>
                        <p class="color-finder" data-value="<?= $shoeColorHexValue ?>" hidden></p>
                      </div>
                    </div>
                  </div>
                </div>

          <?php 
              else :
          ?>

                <div class="product-wrapper__card">
                  <div class="product-wrapper__card-image skeleton">
                    <div class="product__wishlist skeleton"></div>
                    <div class="product-wrapper__rating skeleton"></div>
                  </div>
                  <div class="product-wrapper__details">
                    <div>
                      
                      <div style="width: 100px; height: 15px; background-color: #f7f8fa; margin-bottom: 8px; border-radius: 100px;"></div>
                      <div style="width: 70px; height: 12px; background-color: #f7f8fa; margin-bottom: 10px; border-radius: 100px;"></div>
                      <div class="product-wrapper__card-colors">
                        <div class="product-wrapper__card-colors--btn skeleton"></div>
                        <div class="product-wrapper__card-colors--btn skeleton"></div>
                        <div class="product-wrapper__card-colors--btn skeleton"></div>
                      </div>
                    </div>
                  </div>
                </div>

          <?php 
              endif;
            endfor
          ?>

        </div>
      </div>
    </div>

    <?php require_once 'app/Views/partials/_footer.php' ?>

  </main>

<?php require_once 'app/Views/partials/_script.php' ?>