<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isAdmin()) {
    Utilities::redirectAuthorize('dashboard');
  }
  
  $title = 'Shopping Cart';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';

  $isShippingSet = $shippingController->show($_SESSION['uid']);

  if (count($isShippingSet) > 0) {
    $shippingDetails = $shippingController->showOne($_SESSION['uid']);
  }
  
?>

  <main>

    <?php require_once 'app/Views/partials/_nav.php' ?>

    <div class="shopping-cart">
      <div class="shopping-cart__wrapper">
        <div class="shopping-cart__summary">
          <h1 class="shopping-cart__heading">Order Summary</h1>
          <p class="shopping-cart__subheading">Review and confirm the details of your order before proceeding to ensure a smooth and accurate shopping experience.</p>

          <hr>

          <?php 
            $cartItems = $cartController->show($_SESSION['uid']);
            $cartItemCount = count($cartItems);
            $totalQuantity = 0;
            $totalAmount = 0;

            if ($cartItemCount > 0) :
              foreach ($cartItems as $cartItem) :
                $totalQuantity += $cartItem->quantity;
                $totalAmount += $cartItem->quantity * $cartItem->shoe_price;
                $shoeImage = $shoeImageController->showOne($cartItem->color_id);
          ?>

              <div class="shopping-cart__item">
                <div class="shopping-cart__item--image">
                  <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeImage->shoe_image_id . $shoeImage->extension ?>" alt="<?= $cartItem->shoe_name ?>">
                </div>
      
                <div class="shopping-cart__details">
                  <a href="<?= SYSTEM_URL . 'shoe/details/' . $cartItem->shoe_id ?>" class="shopping-cart__name"><?= $cartItem->shoe_name ?></a>
                  <p class="shopping-cart__category"><?= $cartItem->shoe_categorize_as ?> Shoes</p>
      
                  <p class="shopping-cart__price">₱<?= number_format($cartItem->shoe_price) ?></p>
      
                  <div class="shopping-cart__color-size">
                    <div class="shopping-cart__size">
                      <p>Size</p>
                      <span><?= $cartItem->size ?></span>
                    </div>
                    <div class="shopping-cart__color">
                      <p>Color</p>
                      <div style="background-color: <?= $cartItem->color_hex ?>"></div>
                    </div>
                  </div>
      
                  <div class="shopping-cart__action">
                    <button type="button" class="shopping-cart__action--minus-btn" data-value="<?= $cartItem->cart_id ?>">
                      <i class="ri-subtract-fill"></i>
                    </button>
                    <p class="shopping-cart__count"><?= $cartItem->quantity ?></p>
                    <button type="button" class="shopping-cart__action--add-btn" data-value="<?= $cartItem->cart_id ?>">
                      <i class="ri-add-line"></i>
                    </button>
                  </div>
                </div>
              </div>  

          <?php 
              endforeach;
            else :
          ?>

              <div class="shopping-cart__empty">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/shopping_bag.svg" alt="shooping bag">
                <p>Your shopping cart is currently empty. Start exploring our <br> collection and add your favorite items.</p>
                <a href="<?= SYSTEM_URL . 'shoes/' ?>">Add Item</a>
              </div>

          <?php 
            endif
          ?>

          <hr>

          <div class="shopping-cart__amount">
            <p>Order Quantity</p>
            <p><?= $totalQuantity > 1 ? $totalQuantity . ' shoes' : $totalQuantity . ' shoe' ?></p>
          </div>
          <div class="shopping-cart__amount">
            <p>Total Amount</p>
            <p>₱<?= number_format($totalAmount) ?></p>
          </div>

          <form autocomplete="off" class="shopping-cart__payment-form" id="checkout-form">
            <p>Payment Method</p>
            <div class="shopping-cart__payment">
              <button type="button" class="shopping-cart__tickbox" data-value="COD">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/cash.svg" alt="cod">
                Cash on Delivery
              </button>
              <button type="button" class="shopping-cart__tickbox" data-value="GCash" title="GCash payment is unavailable" disabled>
                <img src="<?= SYSTEM_URL . 'public' ?>/images/gcash.png" alt="gcash">
                GCash
              </button>
            </div>
            <button type="submit" class="shopping-cart__form--submit" id="checkout-btn">
              <div class="spinner"></div>
              Checkout Order
            </button>
          </form>
        </div>

        <div class="shopping-cart__shipping">
          <h1 class="shopping-cart__heading">Shipping Details</h1>
          <p class="shopping-cart__subheading">Provide your shipping information to ensure timely and accurate delivery of your order. Your satisfaction is our priority.</p>

          <hr>

          <form autocomplete="off" class="shopping-cart__shipping-form" id="save-shipping-form">
            <div class="shopping-cart__form-header">
              <p>Set up your shipping information and contact details</p>
              <button type="submit" class="shopping-cart__shipping-form--submit" id="save-shipping-btn">
                <div class="spinner"></div>
                Save
              </button>
            </div>

            <div class="shipping-cart__form-grid">
              <div class="span-2">
                <label for="fullname" class="form-label">Fullname</label>
                <input type="text" name="fullname" class="form-input" placeholder="Enter your fullname" value="<?= $shippingDetails->fullname ?? '' ?>">
              </div>
              <div>
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-input" maxlength="11" placeholder="Enter contact number" value="<?= $shippingDetails->contact_number ?? '' ?>">
              </div>
              <div>
                <label for="email" class="form-label">Email Address</label>
                <input type="text" name="email" class="form-input" placeholder="Enter email address" value="<?= $shippingDetails->email_address ?? '' ?>">
              </div>
              <div>
                <label for="street" class="form-label">Street Name</label>
                <input type="text" name="street" class="form-input" placeholder="Enter street name" value="<?= $shippingDetails->street ?? '' ?>">
              </div>
              <div>
                <label for="zone" class="form-label">Zone #</label>
                <input type="text" name="zone" class="form-input" placeholder="Zone #" value="<?= $shippingDetails->zone ?? '' ?>">
              </div>
              <div>
                <label for="barangay" class="form-label">Barangay</label>
                <input type="text" name="barangay" class="form-input" placeholder="Enter barangay name" value="<?= $shippingDetails->barangay ?? '' ?>">
              </div>
              <div>
                <label for="municipality" class="form-label">Municipality</label>
                <input type="text" name="municipality" class="form-input" placeholder="Enter municipality name" value="<?= $shippingDetails->municipality ?? '' ?>">
              </div>
              <div>
                <label for="province" class="form-label">Province</label>
                <input type="text" name="province" class="form-input" placeholder="Enter province name" value="<?= $shippingDetails->province ?? '' ?>">
              </div>
              <div>
                <label for="zip_code" class="form-label">Zip Code</label>
                <input type="text" name="zip_code" class="form-input" placeholder="Enter zip code" value="<?= $shippingDetails->zip_code ?? '' ?>">
              </div>
            </div>
          </form>

          <div class="shopping-cart__process">
            <p>Delivery Process</p>

            <p>Your order of ₱7,500 or more gets free standard delivery.</p>
            <ul>
              <li>Standard delivered 5-9 Business Days</li>
              <li>Express delivered 2-4 Business Days</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <?php require_once 'app/Views/partials/_footer.php' ?>

  </main>

<?php require_once 'app/Views/partials/_script.php' ?>