<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  if (Utilities::isAdmin()) {
    Utilities::redirectAuthorize('dashboard');
  }
  
  $title = 'Shoe Details';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';

  $shoeId = Utilities::sanitize($id);
  $shoeDetails = $shoeController->showOne($shoeId);
  $shoeMainColor = $colorController->showOne($shoeId);
  $shoeImages = $shoeImageController->show($shoeMainColor->color_id);
  
?>

  <main>

    <?php require_once 'app/Views/partials/_nav.php' ?>

    <div class="view-product">
      <div class="view-product__wrapper">
        <div class="view-product__showcase">
          <div class="view-product__showcase-images">

            <?php 
              foreach ($shoeImages as $index => $shoeImage) : 
            ?>

                <div class="view-product__card <?= $index === 0 ? 'active' : '' ?>">
                  <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeImage->shoe_image_id . $shoeImage->extension ?>" alt="<?= $shoeDetails->shoe_name ?>">
                </div>

            <?php 
              endforeach 
            ?>

          </div>

          <div class="view-product__main-card">
            <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeImages[0]->shoe_image_id . $shoeImages[0]->extension ?>" alt="<?= $shoeDetails->shoe_name ?>" class="view-product__overview">
          </div>
        </div>

        <div class="view-product__details-wrapper">
          <div class="view-product__information">
            <p class="view-product__brand"><?= $shoeDetails->brand_name ?></p>
            <h3 class="view-product__shoe-name"><?= $shoeDetails->shoe_name ?></h3>
            <p class="view-product__category"><?= $shoeDetails->shoe_categorize_as ?> Shoes</p>
            <p class="view-product__price">₱<?= number_format($shoeDetails->shoe_price) ?></p>
            
            <p class="view-product__description"><?= $shoeDetails->shoe_description ?></p>
  
            <hr>
  
            <p class="view-product__heading">Select Colors</p>
            <div class="view-product__colors-wrapper">

              <?php 
                $shoeColors = $colorController->show($shoeId);
                foreach ($shoeColors as $index => $shoeColor) :
              ?>

                  <span type="button" class="view-product__colors--btn <?= Utilities::setDynamicClassname($index, [0]) ?>" style="background-color: <?= $shoeColor->color_hex ?>" data-value="<?= $shoeColor->color_id ?>"></span>
              
              <?php 
                endforeach
              ?>

            </div>
  
            <p class="view-product__heading">Select Size</p>
            <div class="view-product__size-wrapper">

              <?php 
                $shoeSizes = $sizeController->show($shoeId);
                foreach ($shoeSizes as $shoeSize) :
              ?>

                  <span type="button" class="view-product__tickbox" data-value="<?= $shoeSize->size_id ?>"><?= $shoeSize->size ?></span>
              
              <?php 
                endforeach
              ?>

            </div>

            <div class="view-product__button-wrapper">

              <?php 
                if (Utilities::isAuthorize()) :
              ?>

                  <button class="view-product__addcart--btn" data-value="<?= $shoeDetails->shoe_id ?>">
                    <img src="<?= SYSTEM_URL . 'public' ?>/icons/shopping-cart-white.svg" alt="cart">
                    <div class="spinner"></div>
                    Add to Cart
                  </button>
                  <button class="view-product__addwish--btn" data-value="<?= $shoeDetails->shoe_id ?>">
                    <img src="<?= SYSTEM_URL . 'public' ?>/icons/wishlist.svg" alt="wishlist">
                    <div class="spinner"></div>
                    Wishlist
                  </button>

              <?php 
                else :
              ?>

                  <a href="<?= SYSTEM_URL . 'signin' ?>">
                    <img src="<?= SYSTEM_URL . 'public' ?>/icons/shopping-cart-white.svg" alt="cart">
                    <div class="spinner"></div>
                    Add to Cart
                  </a>
                  <a href="<?= SYSTEM_URL . 'signin' ?>">
                    <img src="<?= SYSTEM_URL . 'public' ?>/icons/wishlist.svg" alt="wishlist">
                    Wishlist
                  </a>

              <?php 
               endif
              ?>

            </div>
          </div>

          <div class="view-product__catalog">
            <div>
              <p>Size & Fit</p>
              <i class="ri-arrow-down-s-line"></i>
            </div>

            <ul>
              <li>Fits small; we recommend ordering half a size up</li>
            </ul>
          </div>

          <div class="view-product__catalog">
            <div>
              <p>Delivery Process</p>
              <i class="ri-arrow-down-s-line"></i>
            </div>

            <p>Your order of ₱7,500 or more gets free standard delivery.</p>
            <ul>
              <li>Standard delivered 5-9 Business Days</li>
              <li>Express delivered 2-4 Business Days</li>
            </ul>
          </div>

          <div class="view-product__catalog">
            <div>
              <p>Reviews</p>
              <i class="ri-arrow-down-s-line"></i>
            </div>

            <div>
              <div class="view-product__ratings">

                <?php 
                  $reviewRatings = $reviewController->show($shoeId, $_SESSION['uid'] ?? null);
                  $totalRating = $reviewRatings[0]->review_rating ?? 0;
                  $reviewCount = isset($reviewRatings[0]->review_id) ? count($reviewRatings) : 0;
                  
                  if ($totalRating > 0) {
                    $finalRating = Utilities::calculateReviewRating($totalRating, $reviewCount);

                    for ($reviewIndex = 0; $reviewIndex < $finalRating; $reviewIndex++) {
                      if ($reviewIndex < $finalRating) {
                        echo '<i class="ri-star-fill"></i>';
                      } else {
                        echo '<i class="ri-star-line"></i>';
                      }
                    }
                  }
                ?>

                <?php 
                  if (!isset($finalRating)) :
                ?>

                  <i class="ri-star-line"></i>
                  <i class="ri-star-line"></i>
                  <i class="ri-star-line"></i>
                  <i class="ri-star-line"></i>
                  <i class="ri-star-line"></i>

                <?php 
                  endif
                ?>
                <p><?= isset($finalRating) ? number_format($finalRating, 1) : 'No review rating' ?></p>
              </div>

              <?php 
                if (isset($reviewRatings[0]->review_id)) :
                  foreach ($reviewRatings as $review) :
                    $customer = Utilities::isAuthorize() && $review->account_id === $_SESSION['uid'] ? 'You' : $review->fullname;
              ?>

                  <div class="view-product__review">
                    <p class="view-product__customer"><?= $customer ?></p>
                    <div>
                      <div>

                        <?php 
                          for ($ratingIndex = 0; $ratingIndex < $review->rating; $ratingIndex++) {
                            if ($ratingIndex < $review->rating) {
                              echo '<i class="ri-star-fill"></i>';
                            } else {
                              echo '<i class="ri-star-line"></i>';
                            }
                          }
                        ?>

                      </div>

                      <p class="view-product__posted-date"><?= Utilities::formatDate($review->date_created, 'M d, Y') ?></p>
                    </div>
                    <p class="view-product__review-content"><?= $review->content ?></p>
                  </div>

              <?php 
                  endforeach;
                endif
              ?>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require_once 'app/Views/partials/_footer.php' ?>

  </main>

<?php require_once 'app/Views/partials/_script.php' ?>