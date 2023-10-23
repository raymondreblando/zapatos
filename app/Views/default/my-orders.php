<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isAdmin()) {
    Utilities::redirectAuthorize('dashboard');
  }
  
  $title = isset($type) ? ucwords(str_replace('-', ' ', $type)) : 'Orders';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';
  require_once 'app/Views/partials/_dialog.php';


  $orderParams = $title === 'Orders' ? '' : $title;
  $orders = $orderController->show(Utilities::sanitize($orderParams));
  
?>

  <main>

    <?php require_once 'app/Views/partials/_nav.php' ?>

    <div class="orders">
      <h1 class="orders__heading">Orders</h1>
      <p class="orders__subheading">Keep track of your orders</p>

      <div class="orders__header">
        <ul class="orders__tab-wrapper">
          <li>
            <a href="<?= SYSTEM_URL . 'my-orders/pending' ?>" class="orders_tab <?= Utilities::setDynamicClassname($title, ['Pending']) ?>">Pending</a>
          </li>
          <li>
            <a href="<?= SYSTEM_URL . 'my-orders/ship-out' ?>" class="orders_tab <?= Utilities::setDynamicClassname($title, ['Ship Out']) ?>">Ship Out</a>
          </li>
          <li>
            <a href="<?= SYSTEM_URL . 'my-orders/delivered' ?>" class="orders_tab <?= Utilities::setDynamicClassname($title, ['Delivered']) ?>">Delivered</a>
          </li>
          <li>
            <a href="<?= SYSTEM_URL . 'my-orders/cancelled' ?>" class="orders_tab <?= Utilities::setDynamicClassname($title, ['Cancelled']) ?>">Cancelled</a>
          </li>
        </ul>

        <div class="orders__date-filter">
          <input type="date" id="date-filter" class="orders__date-input">
          <img src="<?= SYSTEM_URL . 'public' ?>/icons/calendar.svg" alt="calendar">
        </div>
      </div>

      <?php
        $ordersCount = count($orders);

        if ($ordersCount > 0) :
      ?>

        <div class="orders__grid">

          <?php 
            foreach ($orders as $order) :
          ?>

              <article class="orders__card search-area">
                <div class="orders__card-header">
                  <div>
                    <p class="orders__order-no"><?= $order->order_no ?></p>
                    <p class="finder1" hidden><?= Utilities::formatDate($order->date_added, 'Y-m-d') ?></p>
                    <p class="orders__order-date">Order Date <?= Utilities::formatDate($order->date_added, 'M d, Y h:i A') ?></p>

                    <?php  
                      if ($order->order_status === 'Pending') :
                    ?>

                        <button class="order__cancel--btn" data-target="<?= $order->order_no ?>" data-value="<?= $order->order_id ?>">Cancel Order</button>

                    <?php  
                      endif
                    ?>
                  </div>
                  
                  <div>
                    <span class="orders__status <?= strtolower($order->order_status) ?>"><?= $order->order_status ?></span>
                  </div>
                </div>

                <p class="orders__label">Shipping Address</p>
                <hr>
                <p class="orders__shipment"><?= $order->fullname ?></p>
                <p class="orders__shipment"><?= $order->street .', ' . $order->zone . ', ' . $order->barangay ?></p>
                <p class="orders__shipment"><?= $order->municipality . ', ' . $order->province . ', ' . $order->zip_code  ?></p>

                <div class="orders__payment">
                  <p class="orders__label">Payment</p>
                  <p class="orders__payment_method"><?= $order->order_mop ?></p>
                </div>

                <hr>

                <?php 
                  $orderItems = $orderItemController->show($order->order_id);

                  foreach ($orderItems as $orderItem) :
                    $shoeMainImage = $shoeImageController->showOne($orderItem->color_id);
                ?>

                    <div class="orders__item">
                      <div class="orders__item--image">
                        <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeMainImage->shoe_image_id . $shoeMainImage->extension ?>" alt="<?= $orderItem->shoe_name ?>">
                      </div>

                      <div class="orders__details">
                        <div class="orders__item-price">
                          <p class="orders__item-name"><?= $orderItem->shoe_name ?></p>
                          <p class="orders__price">P<?= number_format($orderItem->shoe_price) ?></p>
                        </div>
                        <div class="orders__size-color">
                          <div>
                            <p>Size</p>
                            <span><?= $orderItem->size ?></span>
                          </div>

                          <div>
                            <p>Color</p>
                            <div class="orders__color" style="background-color: <?= $orderItem->color_hex ?>"></div>
                          </div>
                        </div>
                        <div class="orders__quantity-review">
                          <p class="orders__quantity">Qty <span><?= $orderItem->quantity ?></span></p>

                          <?php  
                            if ($order->order_status === 'Delivered') :
                          ?>

                            <a href="<?= SYSTEM_URL . 'write-review/' . $orderItem->shoe_id ?>">Write a review</a>
                            
                          <?php 
                            endif
                          ?>
                        </div>

                      </div>
                    </div>

                <?php 
                  endforeach
                ?>


                <div class="orders__total">
                  <p>Total</p>
                  <p>P<?= number_format($order->order_amount) ?></p>
                </div>
              </article>

          <?php 
            endforeach
          ?>

        </div>

      <?php 
        else :
      ?>

          <div class="user-empty-state">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/order-empty.svg" alt="order">
            <p>You have not placed any <span>orders</span> yet.</p>
          </div>

      <?php 
        endif
      ?>
        
    </div>

    <?php require_once 'app/Views/partials/_footer.php' ?>

  </main>

<?php require_once 'app/Views/partials/_script.php' ?>