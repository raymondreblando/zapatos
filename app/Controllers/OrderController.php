<?php

namespace App\Controllers;

use App\Interfaces\AppInterface;
use App\Controllers\CartController;
use App\Controllers\ShippingController;
use App\Utils\DbHelper;
use App\Utils\Utilities;
use App\Utils\PdfCreator;
use Picqer\Barcode\BarcodeGeneratorPNG;
use stdClass;

class OrderController extends PdfCreator implements AppInterface
{
  private $helper;
  private $barcodeGenerator;
  private $cartController;
  private $shippingController;

  public function __construct(DbHelper $helper)
  {
    parent::__construct([
      'format' => [80, 85],
      'orientation' => 'P',
      'margin' => 2
    ]);

    $this->helper = $helper;
    $this->barcodeGenerator = new BarcodeGeneratorPNG();
    $this->cartController = new CartController($helper);
    $this->shippingController = new ShippingController($helper);
  }

  public function show(string $filter = null): array
  {
    $selectOrderParams = [];

    if (!empty($filter) && Utilities::isCustomer()) {
      $selectOrdersQuery = 'SELECT * FROM `orders` o LEFT JOIN `accounts` a ON o.account_id=a.account_id LEFT JOIN `shipping` s ON a.account_id=s.account_id WHERE o.order_status = ? AND o.account_id = ? ORDER BY o.id DESC';
      array_push($selectOrderParams, $filter, $_SESSION['uid']);
    } elseif (empty($filter) && Utilities::isCustomer()){
      $selectOrdersQuery = 'SELECT * FROM `orders` o LEFT JOIN `accounts` a ON o.account_id=a.account_id LEFT JOIN `shipping` s ON a.account_id=s.account_id WHERE o.account_id = ? ORDER BY o.id DESC';
      array_push($selectOrderParams, $_SESSION['uid']);
    } elseif (!empty($filter) && Utilities::isAdmin()) {
      $selectOrdersQuery = 'SELECT *, SUM(oi.quantity) AS order_quantity FROM `orders` o LEFT JOIN `accounts` a ON o.account_id=a.account_id LEFT JOIN `orderred_items` oi ON o.order_id=oi.order_id WHERE o.order_status = ? ORDER BY o.id DESC';
      array_push($selectOrderParams, $filter);
    } else {
      $selectOrdersQuery = 'SELECT *, SUM(oi.quantity) AS order_quantity FROM `orders` o LEFT JOIN `accounts` a ON o.account_id=a.account_id LEFT JOIN `orderred_items` oi ON o.order_id=oi.order_id GROUP BY o.order_id ORDER BY o.id DESC';
    }
    
    $this->helper->query($selectOrdersQuery, $selectOrderParams);
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass
  {
    $selectShoeQuery = 'SELECT * FROM `orders` o LEFT JOIN `accounts` a ON o.account_id=a.account_id LEFT JOIN `shipping` s ON a.account_id=s.account_id WHERE o.order_id = ? ORDER BY o.id DESC';
    $this->helper->query($selectShoeQuery, [$id]);
    return $this->helper->fetch();
  }

  public function insert(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'Select a payment method');
    }

    $cartItems = $this->cartController->show($_SESSION['uid']);

    if (count($cartItems) < 1) {
      return Utilities::response('error', 'Your cart is empty');
    }

    if (count($this->shippingController->show($_SESSION['uid'])) < 1) {
      return Utilities::response('error', 'Set up your shipping details');
    }

    $orderId = Utilities::uuid();
    $orderNo = Utilities::generateOrderNo('Z');
    $currentDate = Utilities::getCurrentDate();
    $totalAmount = 0;

    $this->helper->startTransaction();

    foreach ($cartItems as $cartItem) {
      $totalAmount += ($cartItem->shoe_price * $cartItem->quantity);
      $insertOrderItemParams = [
        $orderId,
        $cartItem->shoe_id,
        $cartItem->size_id,
        $cartItem->color_id,
        $cartItem->quantity,
        $currentDate
      ];
      
      $insertOrderItemQuery = 'INSERT INTO `orderred_items` (`order_id`, `shoe_id`, `size_id`, `color_id`, `quantity`, `date_added`) VALUES (?, ?, ?, ?, ?, ?)';
      $this->helper->query($insertOrderItemQuery, $insertOrderItemParams);

      if ($this->helper->rowCount() < 1) {
        $this->helper->rollback();
        return Utilities::response('error', 'An error occur. Try again');
      }

      $newShoeStocks = $cartItem->shoe_stocks - $cartItem->quantity;
      $updateShoeStockQuery = 'UPDATE `shoes` SET `shoe_stocks` = ? WHERE `shoe_id` = ?';
      $this->helper->query($updateShoeStockQuery, [$newShoeStocks, $cartItem->shoe_id]);

      if ($this->helper->rowCount() < 1) {
        $this->helper->rollback();
        return Utilities::response('error', 'An error occur. Try again');
      }

      if ($newShoeStocks < 25) {
        $notificationId = Utilities::uuid();

        $insertLowStockNitificationParams = [
          $notificationId,
          $cartItem->shoe_id,
          'Low Stock',
          $currentDate
        ];

        $insertLowStockNitificationQuery = 'INSERT INTO `notifications` (`notification_id`, `reference_id`, `notification_type`, `date_created`) VALUES (?, ?, ?, ?, ?)';
        $this->helper->query($insertLowStockNitificationQuery, $insertLowStockNitificationParams);

        if ($this->helper->rowCount() < 1) {
          $this->helper->rollback();
          return Utilities::response('error', 'An error occur. Try again');
        }
      }
    }

    $insertOrderParams = [
      $orderId,
      $orderNo,
      $_SESSION['uid'],
      $totalAmount,
      $payload['mop'],
      $currentDate
    ];

    $insertOrderQuery = 'INSERT INTO `orders` (`order_id`, `order_no`, `account_id`, `order_amount`, `order_mop`, `date_added`) VALUES (?, ?, ?, ?, ?, ?)';
    $this->helper->query($insertOrderQuery, $insertOrderParams);

    if ($this->helper->rowCount() < 1) {
      $this->helper->rollback();
      return Utilities::response('error', 'An error occur. Try again');
    }

    $notificationId = Utilities::uuid();

    $insertOrderNotificationParams = [
      $notificationId,
      $orderId,
      'Order',
      $currentDate
    ];

    $insertOrderNotificationQuery = 'INSERT INTO `notifications` (`notification_id`, `reference_id`, `notification_type`, `date_created`) VALUES (?, ?, ?, ?)';
    $this->helper->query($insertOrderNotificationQuery, $insertOrderNotificationParams);

    if ($this->helper->rowCount() < 1) {
      $this->helper->rollback();
      return Utilities::response('error', 'An error occur. Try again');
    }

    $deleteCartItemQuery = 'DELETE FROM `cart` WHERE `account_id` = ?';
    $this->helper->query($deleteCartItemQuery, [$_SESSION['uid']]);

    if ($this->helper->rowCount() < 1) {
      $this->helper->rollback();
      return Utilities::response('error', 'An error occur. Try again');
    }

    $this->helper->commit();
    return Utilities::response('success', 'We will now process your order. Thankyou');
  }

  public function update(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $isOrderExistQuery = 'SELECT * FROM `orders` o LEFT JOIN `accounts` a ON o.account_id=a.account_id LEFT JOIN `shipping` s ON a.account_id=s.account_id WHERE o.order_id = ?';
    $this->helper->query($isOrderExistQuery, [$payload['order_id']]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $orderDetails = $this->helper->fetch();
    $receiverAddress = $orderDetails->street . ', ' . $orderDetails->zone . ', ' . $orderDetails->barangay . ', ' . $orderDetails->province . ', ' . $orderDetails->zip_code;

    $updateOrderStatusQuery = 'UPDATE `orders` SET `order_status` = ? WHERE `order_id` = ?';
    $this->helper->query($updateOrderStatusQuery, [$payload['status'], $payload['order_id']]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    if ($payload['status'] === 'Ship Out') {
      $filename = $orderDetails->order_no . ' Delivery Receipt';
      $logoSrc = '../../public/icons/Email Logo.svg';
      $barCode = $this->barcodeGenerator->getBarcode($orderDetails->order_no, $this->barcodeGenerator::TYPE_CODE_128);

      $this->setTitle($filename);

      $templateContent = file_get_contents('../../public/template/delivery-receipt.html');
      $templateContent = str_replace('%LOGOSRC%', $logoSrc, $templateContent);
      $templateContent = str_replace('%BARCODE%', base64_encode($barCode), $templateContent);
      $templateContent = str_replace('%ORDERNO%', $orderDetails->order_no, $templateContent);
      $templateContent = str_replace('%RECEIVERNAME%', $orderDetails->fullname, $templateContent);
      $templateContent = str_replace('%RECEIVERADDRESS%', $receiverAddress, $templateContent);

      $this->writeHTML($templateContent);

      ob_start();
      $this->generatePdf($filename, 'P');
      $pdfData = ob_get_clean();

      return $pdfData;
    }

    $message = Utilities::isCustomer() ? 'Order was cancelled successfully' : 'Order status updated successfully';
    return Utilities::response('success', $message);
  }

  public function getTotalSales(string $filter = null): stdClass
  {
    $getTotalSalesParams = ['Delivered'];

    if (!empty($filter)) {
      $getTotalSalesQuery = 'SELECT SUM(order_amount) AS total_sales FROM `orders` WHERE `order_status` = ? AND `date_added` LIKE ?';
      array_push($getTotalSalesParams, '%'. $filter . '%');
    } else {
      $getTotalSalesQuery = 'SELECT SUM(order_amount) AS total_sales FROM `orders` WHERE `order_status` = ?';
    }

    $this->helper->query($getTotalSalesQuery, $getTotalSalesParams);
    return $this->helper->fetch();
  }
}