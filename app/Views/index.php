<?php

  require_once __DIR__.'/../../config/init.php';

  use App\Utils\Utilities;

  Utilities::isAccountUnderVerification();

  if (Utilities::isAdmin()) {
    Utilities::redirectAuthorize('dashboard');
  }
  
  $title = 'Zapatos';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';
  
?>

  <main>

    <?php require_once 'partials/_nav.php' ?>
    
    <section class="hero" id="home">
      <div class="hero__content">
        <p>Our Summer Collections</p>
        <h1>The New Arrival</h1>
        <h1><span class="hero__highlight">Nike</span> Shoes</h1>
        <p>Elevate your style with our exclusive collection of comfortable <br> and fashionable footwear for every occasion.</p>
        <a href="<?= SYSTEM_URL . 'shoes/' ?>" class="hero__shop--btn">
          Shop now
          <img src="<?= SYSTEM_URL . 'public' ?>/icons/arrow.svg" alt="arrow">
        </a>

        <div class="hero__count">
          <div>
            <h2 class="hero__count--heading">1k+</h2>
            <p class="hero__count--subheading">Brands</p>
          </div>
          <div>
            <h2 class="hero__count--heading">10k+</h2>
            <p class="hero__count--subheading">Products</p>
          </div>
          <div>
            <h2 class="hero__count--heading">100k+</h2>
            <p class="hero__count--subheading">Customers</p>
          </div>
        </div>
      </div>

      <div class="hero__image">
        <div class="hero__overlay"></div>
        
        <div class="hero__shoe">
          <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-10.png" alt="shoe" class="hero__shoe--image">
        </div>

        <div class="hero__card--container">
          <div class="hero__card">
            <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-2.png" alt="shoe">
          </div>
          <div class="hero__card active">
            <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-10.png" alt="shoe">
          </div>
          <div class="hero__card">
            <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-3.png" alt="shoe">
          </div>
        </div>
      </div>
    </section>

    <section class="product" id="products">
      <div class="product__heading">
        <div>
          <h3>Our <span>Popular</span> Products</h3>
          <p>Explore the hottest shoe trends loved by our customers – <br> Get ready to step into the latest fashion!</p>
          <a href="<?= SYSTEM_URL . 'shoes/' ?>">Explore All Products </a>
        </div>

        <div class="product__heading-actions">
          <button type="button" class="product__slider--btn prev-btn"><i class="ri-arrow-left-s-line"></i></button>
          <button type="button" class="product__slider--btn next-btn"><i class="ri-arrow-right-s-line"></i></button>
        </div>
      </div>

      <div class="product__slider">

        <?php  
          $maxPopularProductCount = 6;
          $popularShoes = $shoeController->show();
          $popularShoeCount = count($popularShoes);
          $maxPopularIndex = $popularShoeCount > $maxPopularProductCount ? $maxPopularProductCount : $popularShoeCount;

          for ($popularShoeIndex = 0; $popularShoeIndex < $maxPopularIndex; $popularShoeIndex++) :
            $shoeMainColor = $colorController->showOne($popularShoes[$popularShoeIndex]->shoe_id);
            $shoeMainImage = $shoeImageController->showOne($shoeMainColor->color_id);
            $reviewRatings = $reviewController->show($popularShoes[$popularShoeIndex]->shoe_id);
            $totalRating = $reviewRatings[0]->review_rating ?? 0;
            $reviewCount = isset($reviewRatings[0]->review_id) ? count($reviewRatings) : 0;
            $finalRating = $totalRating > 0 ? Utilities::calculateReviewRating($totalRating, $reviewCount) : 0;
        ?>

            <div class="product__card">
              <div class="product__card--img">
                <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeMainImage->shoe_image_id . $shoeMainImage->extension ?>" alt="<?= $popularShoes[$popularShoeIndex]->shoe_name ?>">
              </div>
              <div class="product__rating">
                <i class="ri-star-fill"></i>
                <p><?= $finalRating > 0 ? $finalRating : 'No reviews' ?></p>
              </div>
              <a href="<?= SYSTEM_URL . 'shoe/details/' . $popularShoes[$popularShoeIndex]->shoe_id ?>"><?= $popularShoes[$popularShoeIndex]->shoe_name ?></a>
              <p>P<?= number_format($popularShoes[$popularShoeIndex]->shoe_price) ?></p>
            </div>
        
        <?php 
          endfor
        ?>
        
      </div>
    </section>

    <section class="service" id="services">
      <div class="service__wrapper">
        <div class="service__content">  
          <h3>We Provide You <span>High Quality</span> Shoes</h3>
          <p>
            At <span>Zapatos</span>, we take pride in delivering shoes of superlative quality. Our commitment to excellence is evident in every pair we offer. Each shoe is meticulously crafted with precision and infused with the passion to create footwear that not only meets but exceeds your expectations. 
            <br> <br>
            Our dedication to superior craftsmanship and attention to detail ensures that every step you take is a step toward unrivaled comfort and style. Explore our exquisite collection, where each shoe is a testament to our unwavering pursuit of excellence. 
          </p>
          <a href="<?= SYSTEM_URL . 'shoes/' ?>" class="service__shop--btn">
            Shop now
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/arrow.svg" alt="arrow">
          </a>
        </div>
        <div class="service__image">
          <img src="<?= SYSTEM_URL . 'public' ?>/images/service-image.png" alt="service image">
        </div>
      </div>

      <div class="service__grid">
        <div class="service__card">
          <div class="service__card--icon">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/seamless-icon.svg" alt="seamless transaction">
          </div>
          <h4>Seamless Transaction</h4>
          <p>Streamlined Shopping Experience with Ironclad Security for Smooth and Worry-Free Transactions Every Time You Shop.</p>
        </div>
        <div class="service__card">
          <div class="service__card--icon">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/shipping-icon.svg" alt="free shipping">
          </div>
          <h4>Free Shipping</h4>
          <p>Enjoy the Convenience of Free Shipping, Wherever You Are - Because Exceptional Style Should Know No Boundaries.</p>
        </div>
        <div class="service__card">
          <div class="service__card--icon">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/payment-icon.svg" alt="secure payments">
          </div>
          <h4>Secure Payments</h4>
          <p>Confidence in Every Transaction: Our Fortified Payment System Ensures Your Personal and Financial Data Stays Safe and Protected.</p>
        </div>
        <div class="service__card">
          <div class="service__card--icon">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/heart-icon.svg" alt="eager to assist">
          </div>
          <h4>Eager to Assist You</h4>
          <p>Always Eager to Assist You: Our Team's Commitment to Your Satisfaction is Unwavering. Your Needs, Our Priority.</p>
        </div>
      </div>
    </section>

    <section class="exclusive-offer">
      <div class="exclusive-offer__wrapper">
        <div class="exclusive-offer__grid">
          <div class="exclusive-offer__card">
            <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-8.png" alt="shoe">
          </div>
          <div class="exclusive-offer__card">
            <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-9.png" alt="shoe">
          </div>
          <div class="exclusive-offer__card">
            <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-10.png" alt="shoe">
          </div>
          <div class="exclusive-offer__card">
            <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-11.png" alt="shoe">
          </div>

          <div class="exclusive-offer__badge">
            <span>30% <br> Off</span>
          </div>
        </div>

        <div class="exclusive-offer__content">
          <h3><span>Exclusive</span> Offer <br> Just For You</h3>
          <p>
            At <span>Zapatos</span>, we believe in making your shopping experience extraordinary. That's why we're excited to present our latest special offer just for you.
            <br><br>
            Prepare to be delighted as we unveil remarkable discounts, exclusive bundles, and special promotions that will elevate your shoe shopping. Whether you're seeking trendy sneakers, elegant heels, or versatile boots, now is the perfect time to indulge in top-quality footwear without breaking the bank. Hurry, as this limited-time offer won't last forever. 
          </p>
          <div class="exclusive-offer__button-wrapper">
            <a href="<?= SYSTEM_URL . 'shoes/' ?>" class="exclusive-offer__shop--btn">
              Shop now
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/arrow.svg" alt="arrow">
            </a>
            <button type="button" class="exclusive-offer__learn--btn">
              Learn more
            </button>
          </div>
        </div>
      </div>
    </section>

    <section class="testimonials" id="testimonials">
      <h3 class="testimonials__heading">What Our <span>Customer</span> Says?</h3>
      <p class="testimonials__subheading">
        Discover the Voice of Our Valued Customers - Their Experiences, Satisfaction, and <br> 
        Stories of Finding Perfect Footwear at <span>Zapatos</span>.
      </p>

      <div class="testimonials__grid">
        <?php 
          $customerReviews = $reviewController->showLatestReviews();

          foreach ($customerReviews as $review) :
        ?>

            <div class="testimonials__card">
              <div class="testimonials__card-heading">
                <span class="testimonials__icon"><i class="ri-double-quotes-l"></i></span>
                <div class="testimonials__rating">
                  <i class="ri-star-fill"></i>
                  <?= $review->rating ?>
                </div>
              </div>
              <p class="testimonials__content"><?= $review->content ?></p>
              <div class="testimonials__customer">
                <div class="testimonials__acronym"><?= substr($review->fullname, 0, 1) ?></div>
                <div class="testimonials__customer-details">
                  <p><?= $review->fullname ?></p>
                  <p>Customer</p>
                </div>
              </div>
            </div>
            
        <?php 
          endforeach
        ?>

      </div>
    </section>

    <section class="newsletter">
      <h3>Subscribe To Our Newsletter, <br> For <span>Products</span> Updates</h3>

      <form class="newsletter__form" id="newsletter-form" autocomplete="off">
        <div class="newsletter__form-group">
          <input type="text" name="email" placeholder="example@gmail.com">
          <button type="submit" id="newsletter-btn">
            <div class="spinner"></div>
            Subscribe
          </button>
        </div>
      </form>
    </section>

    <?php require_once 'partials/_footer.php' ?>

  </main>

<?php require_once 'partials/_script.php' ?>