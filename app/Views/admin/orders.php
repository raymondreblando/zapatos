<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = isset($type) ? ucwords(str_replace('-', ' ', $type)) : 'Orders';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';

  $orderParams = $title === 'Orders' ? '' : $title;
  $orders = $orderController->show(Utilities::sanitize($orderParams));

?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content">
        <div class="main__content-header">
          <div>
            <h1 class="main__content-heading">Orders</h1>
            <p class="main__content-subheading">Manage customer orders.</p>
          </div>
        </div>

        <div class="main__filter-wrapper">
          <div class="main__tabs">
            <a href="<?= SYSTEM_URL . 'orders/' ?>" class="<?= Utilities::setDynamicClassname($title, ['Orders']) ?>">All</a>
            <a href="<?= SYSTEM_URL . 'orders/pending' ?>" class="<?= Utilities::setDynamicClassname($title, ['Pending']) ?>">Pending</a>
            <a href="<?= SYSTEM_URL . 'orders/ship-out' ?>" class="<?= Utilities::setDynamicClassname($title, ['Ship Out']) ?>">Ship Out</a>
            <a href="<?= SYSTEM_URL . 'orders/delivered' ?>" class="<?= Utilities::setDynamicClassname($title, ['Delivered']) ?>">Delivered</a>
            <a href="<?= SYSTEM_URL . 'orders/cancelled' ?>" class="<?= Utilities::setDynamicClassname($title, ['Cancelled']) ?>">Cancelled</a>
          </div>

          <div class="input-group">
            <div class="custom-date">
              <input type="date" class="date-start">
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/calendar.svg" alt="calendar">
            </div>

            <p>To</p>

            <div class="custom-date">
              <input type="date" class="date-end">
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/calendar.svg" alt="calendar">
            </div>
          </div>
        </div>

        <div class="main__order-list">
          <div class="table-responsive">
            <table>
              <thead>
                <th>Order No</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Quantity</th>
                <th>MOP</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </thead>
              <tbody>

                <?php  
                  $orderPlaceholderCount = 8;
                  $totalOrdersCount = count($orders);
                  $maxOrderRecord = $totalOrdersCount > $orderPlaceholderCount ? $totalOrdersCount : $orderPlaceholderCount;
                  for ($orderIndex = 0; $orderIndex < $maxOrderRecord; $orderIndex++) :
                    if (isset($orders[$orderIndex]) && isset($orders[$orderIndex]->order_id)) :
                ?>

                      <tr class="search-area">
                        <td class="finder1"><?= $orders[$orderIndex]->order_no ?></td>
                        <td>
                          <div class="table__customer">
                            <div class="table__customer-acronym">
                              <?= substr($orders[$orderIndex]->fullname, 0, 1) ?>
                            </div>
                            <div>
                              <p class="finder2"><?= $orders[$orderIndex]->fullname ?></p>
                              <p>Customer</p>
                            </div>
                          </div>
                        </td>
                        <td>₱<?= number_format($orders[$orderIndex]->order_amount) ?></td>
                        <td><?= $orders[$orderIndex]->order_quantity ?></td>
                        <td class="finder3"><?= $orders[$orderIndex]->order_mop ?></td>
                        <td>
                          <span class="finder4 table__order-status <?= str_replace(' ', '', strtolower($orders[$orderIndex]->order_status)) ?>"><?= $orders[$orderIndex]->order_status ?></span>
                        </td>
                        <td><?= Utilities::formatDate($orders[$orderIndex]->date_added, 'm-d-Y') ?></td>
                        <td class="date-value finder5" hidden><?= Utilities::formatDate($orders[$orderIndex]->date_added, 'Y-m-d') ?></td>
                        <td width="10%">
                          <a href="<?= SYSTEM_URL . 'order/details/' . $orders[$orderIndex]->order_id ?>" class="table__link">
                            <i class="ri-more-line"></i>
                            More
                          </a>
                          
                        </td>
                      </tr>

                <?php 
                    else :
                ?>

                      <tr>
                        <td>
                          <div style="width: 40px; height: 12px; background-color: #f7f8fa; border-radius: 100px;"></div>
                        </td>
                        <td>
                          <div class="table__shoes">
                            <div class="table__shoe-image skeleton">
                            </div>
                            <div>
                              <div style="width: 85px; height: 13px; background-color: #f7f8fa; margin-bottom: 4px; border-radius: 100px;"></div>
                              <div style="width: 35px; height: 10px; background-color: #f7f8fa; border-radius: 100px;"></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                        </td>
                        <td>
                          <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                        </td>
                        <td>
                          <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                        </td>
                        <td>
                          <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                        </td>
                        <td>
                          <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                        </td>
                        <td>
                          <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                        </td>
                      </tr>

                <?php  
                    endif;
                  endfor
                ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require_once 'app/Views/partials/_script.php' ?>