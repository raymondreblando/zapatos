<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';

date_default_timezone_set('Asia/Hong_Kong');

use Dotenv\Dotenv;
use Config\Database;
use App\Utils\Utilities;
use App\Utils\DbHelper;
use App\Providers\AuthProvider;
use App\Controllers\BrandController;
use App\Controllers\CategoryController;
use App\Controllers\ShoeController;
use App\Controllers\SizeController;
use App\Controllers\ColorController;
use App\Controllers\ShoeImageController;
use App\Controllers\OrderController;
use App\Controllers\OrderItemController;
use App\Controllers\ReviewController;
use App\Controllers\WishlistController;
use App\Controllers\CartController;
use App\Controllers\ShippingController;
use App\Controllers\CustomerController;
use App\Controllers\ReportController;
use App\Controllers\SettingController;
use App\Controllers\NotificationController;

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$database = new Database();
$conn = $database->getConnetion($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

$helper = new DbHelper($conn);
$authProvider = new AuthProvider($helper);
$brandController = new BrandController($helper);
$categoryController = new CategoryController($helper);
$shoeController = new ShoeController($helper);
$sizeController = new SizeController($helper);
$colorController = new ColorController($helper);
$shoeImageController = new ShoeImageController($helper);
$orderController = new OrderController($helper);
$orderItemController = new OrderItemController($helper);
$reviewController = new ReviewController($helper);
$wishlistController = new WishlistController($helper);
$cartController = new CartController($helper);
$shippingController = new ShippingController($helper);
$customerController = new CustomerController($helper);
$reportController = new ReportController($helper);
$settingController = new SettingController($helper);
$notificationController = new NotificationController($helper);

date_default_timezone_set('Asia/Manila');
define('SYSTEM_URL', $_ENV['SYSTEM_URL']);