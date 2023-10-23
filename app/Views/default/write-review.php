<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isAdmin()) {
    Utilities::redirectAuthorize('dashboard');
  }
  
  $title = 'Write A Review';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';

  $shoeId= Utilities::sanitize($id);
  
?>

  <main>

    <?php require_once 'app/Views/partials/_nav.php' ?>

    <div class="review">
      <div class="review__wrapper">
        <div class="review__product">
          <div class="review__shoe--image">
            <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-1.png" alt="shoe">
          </div>
          <p class="review__brand">Nike</p>
          <h3 class="review__shoe-name">Nike Air Max 270</h3>
          <p class="review__category">Men Shoes</p>
          <p class="review__price">₱7,645</p>
          
          <p class="review__description">
            Nike's first lifestyle Air Max brings you style, comfort and big attitude in the Nike Air Max 270. The design draws inspiration from Air Max icons, showcasing Nike's greatest innovation with its large window and fresh array of colours.
          </p>
        </div>

        <div class="review__form-wrapper">
          <a href="<?= SYSTEM_URL . 'shoe/details/' . $shoeId ?>">Back</a>
          <h1 class="review__heading">Share Your <span>Experience</span>!</h1>
          <p class="review__subheading">We greatly value your feedback and opinions about our products and service. Sharing your experience helps us improve and assists other shoppers in making informed decisions.</p>

          <form id="save-review-form" autocomplete="off">
            <h3>Rate Your Experience</h3>
            <p>Rate your overall experience from 1 to 5 stars</p>
            <div class="review__rating">
              <input type="hidden" name="rating" class="review__rating--input">
              <i type="button" class="ri-star-line" data-rating></i>
              <i type="button" class="ri-star-line" data-rating></i>
              <i type="button" class="ri-star-line" data-rating></i>
              <i type="button" class="ri-star-line" data-rating></i>
              <i type="button" class="ri-star-line" data-rating></i>
            </div>

            <p>Share your detailed thoughts and experiences in the text box</p>
            <input type="hidden" name="sid" value="<?= $shoeId ?>">
            <textarea name="review" class="review__txt-box" placeholder="Write a review"></textarea>

            <button type="submit" class="review__form--button" id="save-review-btn">
              <div class="spinner"></div>
              Post Review
            </button>
          </form>
        </div>
      </div>
    </div>

    <?php require_once 'app/Views/partials/_footer.php' ?>

  </main>

<?php require_once 'app/Views/partials/_script.php' ?>