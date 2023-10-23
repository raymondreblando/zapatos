<?php

  use App\Utils\Utilities;

  $shoeLinkStyling = $title === 'Shoes' ? 'active' : '';
  $newArrivalLinkStyling = $title === 'New Arrival' ? 'active' : '';
  $menLinkStyling = $title === 'Men' ? 'active' : '';
  $womenLinkStyling = $title === 'Women' ? 'active' : '';
  $kidsLinkStyling = $title === 'Kids' ? 'active' : '';
  $orderLinkStyling = $title === 'My Orders' ? 'active' : '';

?>

<header>
  <nav class="header__nav">
    <div class="header__logo">
      <a href="<?= SYSTEM_URL ?>">Zapatos</a>
    </div>

    <?php if($title === 'Zapatos'): ?>

      <ul class="header__menu">
        <li>
          <a href="#home" class="header__link active" data-target="home">Home</a>
        </li>
        <li>
          <a href="#products" class="header__link" data-target="products">Products</a>
        </li>
        <li>
          <a href="#services" class="header__link" data-target="services">Services</a>
        </li>
        <li>
          <a href="#testimonials" class="header__link" data-target="testimonials">Testimonials</a>
        </li>
        <li>
          <a href="signin.html" class="header__signin--mobile">Sign In</a>
        </li>
      </ul>

    <?php else: ?>
      
      <ul class="header__menu">
        <li>
          <a href="<?= SYSTEM_URL . 'shoes/' ?>" class="header__link <?= $shoeLinkStyling ?>">Shoes</a>
        </li>
        <li>
          <a href="<?= SYSTEM_URL . 'shoes/new-arrival' ?>" class="header__link <?= $newArrivalLinkStyling ?>">New Arrival</a>
        </li>
        <li>
          <a href="<?= SYSTEM_URL . 'shoes/men' ?>" class="header__link <?= $menLinkStyling ?>">Men</a>
        </li>
        <li>
          <a href="<?= SYSTEM_URL . 'shoes/women' ?>" class="header__link <?= $womenLinkStyling ?>">Women</a>
        </li>

        <?php 
          if (Utilities::isAuthorize()) :
        ?>

            <li>
              <a href="<?= SYSTEM_URL . 'my-orders/' ?>" class="header__link <?= $orderLinkStyling ?>">Orders</a>
            </li>

        <?php 
          endif
        ?>

      </ul>

    <?php endif ?>

    <ul class="header__menu--mobile">

      <?php 
        if (Utilities::isAuthorize()) :
          $cartItemCount = count($cartController->show($_SESSION['uid']));
      ?>

          <li>
            <a href="<?= SYSTEM_URL . 'wishlist' ?>" class="header__wishlist">
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/wishlist.svg" alt="wishlist">
            </a>
          </li>
          <li>
            <a href="<?= SYSTEM_URL . 'cart' ?>" class="header__cart">
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/shopping-cart.svg" alt="cart">

              <?php if ($cartItemCount > 0) : ?>

                <span><?= $cartItemCount ?></span>

              <?php endif ?>

            </a>
          </li>
      
      <?php 
        else :
      ?>

          <li>
            <a href="<?= SYSTEM_URL . 'signin' ?>" class="header__wishlist">
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/wishlist.svg" alt="wishlist">
            </a>
          </li>
          <li>
            <a href="<?= SYSTEM_URL . 'signin' ?>" class="header__cart">
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/shopping-cart.svg" alt="cart">
            </a>
          </li>

      <?php 
        endif
      ?>
      
      <?php 
        if (Utilities::isAuthorize()) :
      ?>

          <li>
            <a href="<?= SYSTEM_URL . 'signout' ?>" class="header__signin">Sign Out</a>
          </li>

      <?php 
        else :
      ?>

          <li>
            <a href="<?= SYSTEM_URL . 'signin' ?>" class="header__signin">Sign In</a>
          </li>

      <?php 
        endif
      ?>
      <button type="button" class="header__show--btn"><i class="ri-menu-4-line"></i></button>
    </ul>
  </nav>
</header>