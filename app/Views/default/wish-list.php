<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isAdmin()) {
    Utilities::redirectAuthorize('dashboard');
  }
  
  $title = 'Wishlist';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';
  require_once 'app/Views/partials/_dialog.php';
  
?>

  <main>

    <?php require_once 'app/Views/partials/_nav.php' ?>

    <div class="wishlist-wrapper">
      <div class="wishlist-wrapper__header">
        <div class="wishlist-wrapper__header-heading">
          <p>My Wishlist</p>
          <p>Keep track of your favourite shoes</p>
        </div>

        <div class="wishlist-wrapper__filter-search">
          <div class="wishlist-wrapper__searchbar">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/search.svg" alt="search">
            <input type="text" id="search-input" placeholder="Search" autocomplete="off">
          </div>
        </div>
      </div>

      <?php 
        $wishlists = $wishlistController->show($_SESSION['uid']);
        $wishlistRecordCount = count($wishlists);

        if ($wishlistRecordCount > 0) :
      ?>

          <div class="wishlist-wrapper__grid">

      <?php 
          foreach ($wishlists as $wishlist) : 
            $shoeImage = $shoeImageController->showOne($wishlist->color_id);
      ?>

            <div class="wishlist-wrapper__card search-area">
              <div class="wishlist-wrapper__card--image">
                <div class="wishlist-wrapper__rating">
                  <i class="ri-star-fill"></i>
                  <p>5.0</p>
                </div>
                <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeImage->shoe_image_id . $shoeImage->extension ?>" alt="<?= $wishlist->shoe_name ?>">
              </div>

              <div class="wishlist-wrapper__details">
                <p class="finder1 wishlist-wrapper__brand"><?= $wishlist->brand_name ?></p>
                <a href="<?= SYSTEM_URL . 'shoe/details/' . $wishlist->shoe_id ?>" class="finder2 wishlist-wrapper__name"><?= $wishlist->shoe_name ?></a>
                <p class="finder3 wishlist-wrapper__category"><?= $wishlist->shoe_categorize_as ?> Shoes</p>

                <p class="finder4 wishlist-wrapper__price">₱<?= number_format($wishlist->shoe_price) ?></p>

                <div class="wishlist-wrapper__color-size">
                  <div class="wishlist-wrapper__size">
                    <p>Size</p>
                    <span><?= $wishlist->size ?></span>
                  </div>
                  <div class="wishlist-wrapper__color">
                    <p>Color</p>
                    <div style="background-color: <?= $wishlist->color_hex ?>"></div>
                  </div>
              </div>

                <div class="wishlist-wrapper__action">
                  <button type="button" class="wishlist-wrapper__action--cart-btn" data-value="<?= $wishlist->wishlist_id ?>">
                    <img src="<?= SYSTEM_URL . 'public' ?>/icons/shopping-cart-white.svg" alt="cart">
                  </button>
                  <button type="button" class="wishlist-wrapper__action--remove-btn" data-target="<?= $wishlist->shoe_name ?>" data-value="<?= $wishlist->wishlist_id ?>">
                    <img src="<?= SYSTEM_URL . 'public' ?>/icons/delete.svg" alt="remove">
                  </button>
                </div>
              </div>
            </div>

      <?php  
          endforeach
      ?>

          </div>

      <?php 
        else :
      ?>
      
          <div class="user-empty-state">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/heart-filled.svg" alt="wishlist">
            <p>Your <span>wishlist</span> is currently empty. Start adding your favorite items <br> to create your perfect shopping list</p>
          </div>

      <?php 
        endif
      ?>
      
    </div>

    <?php require_once 'app/Views/partials/_footer.php' ?>

  </main>

<?php require_once 'app/Views/partials/_script.php' ?>