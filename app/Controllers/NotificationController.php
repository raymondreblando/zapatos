<?php

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;

class NotificationController 
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(): array
  {
    $selectNotificationQuery = 'SELECT * FROM `notifications` ORDER BY `notification_status` DESC';
    $this->helper->query($selectNotificationQuery);

    return $this->helper->fetchAll();
  }

  public function getUnreadNotifications(): int
  {
    $selectNotificationQuery = 'SELECT * FROM `notifications` WHERE `notification_status` = ?';
    $this->helper->query($selectNotificationQuery, [0]);
    
    return $this->helper->rowCount();
  }

  public function update(string $id): string
  {
    if (empty($id)) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $isNotificationExistQuery = 'SELECT * FROM `notifications` WHERE `notification_id` = ?';
    $this->helper->query($isNotificationExistQuery, [$id]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $notificationData = $this->helper->fetch();

    $updateNotificationStatusQuery = 'UPDATE `notifications` SET `notification_status` = ? WHERE `notification_id` = ?';
    $this->helper->query($updateNotificationStatusQuery, [1, $id]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    if ($notificationData->notification_type === 'Order') {
      $redirectLink = SYSTEM_URL . 'order/details/' . $notificationData->reference_id;
    } else {
      $redirectLink = SYSTEM_URL . 'shoe/update/' . $notificationData->reference_id;
    }

    return Utilities::response('success', $redirectLink);
  }
}