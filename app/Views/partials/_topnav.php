<nav class="main__nav">
  <div class="nav__menu-search">
    <button type="button" class="nav__show-sidebar--btn"><i class="ri-menu-5-line"></i></button>
    
    <button type="button" class="nav__show-search--btn"><img src="<?= SYSTEM_URL . 'public' ?>/icons/search.svg" alt="search"></button>

    <div class="searchbar">
      <img src="<?= SYSTEM_URL . 'public' ?>/icons/search.svg" alt="search">
      <input type="text" id="search-input" autocomplete="off" placeholder="Search">
    </div>
  </div>

  <?php 
    $unreadNotificationCount = $notificationController->getUnreadNotifications();
    $notifications = $notificationController->show();
  ?>

  <div class="nav__options">
    <div class="nav__notifications">
      <img src="<?= SYSTEM_URL . 'public' ?>/icons/notification.svg" alt="notification" class="nav__notifications--img">

      <?php 
        if ($unreadNotificationCount > 0) :
      ?>

          <span class="nav__notifications-count"><?= $unreadNotificationCount ?></span>

      <?php 
        endif
      ?>

      <div class="nav__notification-dropdown">
        <p class="notification__heading">Notifications</p>
        <p class="notification__subheading">You have <span><?= $unreadNotificationCount ?></span> new notifications</p>

          <?php 
            foreach ($notifications as $notification) :
              $className = $notification->notification_status == 0 ? 'unread' : '';

              if ($notification->notification_type === 'Order') {
                $referenceData = $orderController->showOne($notification->reference_id);
                $notificationContent = 'A new order from <span>' . $referenceData->fullname . '</span> has been placed. Checkout the order details.';
              } else {
                $referenceData = $shoeController->showOne($notification->reference_id);
                $notificationContent = 'Stocks for ' . $referenceData->shoe_name . ' is getting low. Restock now.';
              }
          ?>

              <div class="nav__notification-wrapper <?= $className ?>" data-value="<?= $notification->notification_id ?>">
                <p><?= $notificationContent ?></p>
              </div>

          <?php 
            endforeach
          ?>

      </div>
    </div>

    <a href="<?= SYSTEM_URL . 'signout' ?>" class="nav__logout"><i class="ri-logout-circle-line"></i></a>

    <div class="nav__profile">
      <img src="<?= SYSTEM_URL . 'public' ?>/images/customer-2.jpg" alt="profile">
    </div>
  </div>
</nav>