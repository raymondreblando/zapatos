<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = 'Order Details';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';

  $orderId = Utilities::sanitize($id);
  $orderDetails = $orderController->showOne($orderId);
  
?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content">
        <div class="main__breadcrumbs-wrapper">
          <a href="<?= SYSTEM_URL . 'orders/' ?>" class="main__breadcrumbs">Orders</a>
          <span><i class="ri-arrow-right-s-line"></i></span>
          <a href="<?= SYSTEM_URL . 'order/details/' . $orderId ?>" class="main__breadcrumbs active">Details</a>
        </div>

        <div class="main__content-header">
          <div>
            <h1 class="main__content-heading">Order Information</h1>
            <p class="main__content-subheading">View and confirm order information.</p>
          </div>

          <?php 
            $newOrderData = [];

            if ($orderDetails->order_status === 'Pending') {
              $newOrderData['status'] = 'Ship Out';
              $newOrderData['label'] = 'Confirm Order';
            } elseif ($orderDetails->order_status === 'Ship Out') {
              $newOrderData['status'] = 'Delivered';
              $newOrderData['label'] = 'Order Delivered';
            } else {
              $newOrderData['status'] = '';
              $newOrderData['label'] = '';
            }
          ?>

          <?php
            if ($orderDetails->order_status !== 'Delivered') :
          ?>

              <button type="button" id="change-order-status" class="main__create" data-value="<?= $orderDetails->order_id ?>" data-status="<?= $newOrderData['status'] ?>">
                <div class="spinner"></div>
                <?= $newOrderData['label'] ?>
              </button>

          <?php
            else :
          ?>

              <span class="main__create delivered">Delivered</span>

          <?php
            endif
          ?>

        </div>

        <div class="main__order-details">
          <div class="main__order-header">
            <p class="main__order-heading">Customer & Contact</p>
            <div class="main__customer-details">
              <div>
                <p>Receiver</p>
                <p><?= $orderDetails->fullname ?></p>
              </div>
              <div>
                <p>Contact Number</p>
                <p><?= $orderDetails->contact_number ?></p>
              </div>
              <div>
                <p>Email</p>
                <p><?= $orderDetails->email ?></p>
              </div>
            </div>
          </div>
          <div class="main__order-header">
            <p class="main__order-heading">Shipping</p>
            <div class="main__shipping-details">
              <div>
                <p>Street Name</p>
                <p><?= $orderDetails->street ?></p>
              </div>
              <div>
                <p>Zone</p>
                <p><?= $orderDetails->zone ?></p>
              </div>
              <div>
                <p>Barangay</p>
                <p><?= $orderDetails->barangay ?></p>
              </div>
              <div>
                <p>Municipality</p>
                <p><?= $orderDetails->municipality ?></p>
              </div>
              <div>
                <p>Province</p>
                <p><?= $orderDetails->province ?></p>
              </div>
              <div>
                <p>Zip Code</p>
                <p><?= $orderDetails->zip_code ?></p>
              </div>
            </div>
          </div>

          <br>

          <div class="table-responsive">
            <table>
              <thead>
                <th>Shoe</th>
                <th>Price</th>
                <th>Size</th>
                <th>Color</th>
                <th>Quantity</th>
                <th width="10%">Subtotal</th>
              </thead>
              <tbody>

                <?php 
                  $totalAmount = 0;
                  $orderItems = $orderItemController->show($orderId);

                  foreach ($orderItems as $orderItem) :
                    $totalAmount += ($orderItem->shoe_price * $orderItem->quantity);
                    $shoeMainImage = $shoeImageController->showOne($orderItem->color_id);
                ?>

                    <tr>
                      <td>
                        <div class="table__shoes">
                          <div class="table__shoe-image">
                            <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeMainImage->shoe_image_id . $shoeMainImage->extension ?>" alt="<?= $orderItem->shoe_name ?>">
                          </div>
                          <div>
                            <p><?= $orderItem->shoe_name ?></p>
                            <p><?= $orderItem->brand_name ?></p>
                          </div>
                        </div>
                      </td>
                      <td>₱<?= number_format($orderItem->shoe_price) ?></td>
                      <td>
                        <div class="table__size">
                          <?= $orderItem->size ?>
                        </div>
                      </td>
                      <td>
                        <div class="table__colors">
                          <span style="background-color: <?= $orderItem->color_hex ?>"></span>
                        </div>
                      </td>
                      <td><?= $orderItem->quantity > 1 ? $orderItem->quantity . ' Pairs' : $orderItem->quantity . ' Pair' ?></td>
                      <td>₱<?= number_format($orderItem->shoe_price * $orderItem->quantity) ?></td>
                    </tr>

                <?php 
                  endforeach
                ?>

                <tr>
                  <td colspan="5" class="table__summary">Total Amount</td>
                  <td class="table__summary">₱<?= number_format($totalAmount) ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require_once 'app/Views/partials/_script.php' ?>