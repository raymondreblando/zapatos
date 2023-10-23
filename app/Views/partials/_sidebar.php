<?php 

  use App\Utils\Utilities;

  $shoeTitles = ['Shoes', 'Add New Shoe', 'Update Shoe Details', 'New Arrival', 'Top Selling'];
  $orderTitles = ['Orders', 'Order Details', 'Pending', 'Ship Out', 'Delivered', 'Cancelled'];
  $customerTitles = ['Customers', 'Active', 'Deactivated'];
  $reportTitles = ['Reports', 'Sales', 'Inventory'];

  $dashboardLinkStyling = Utilities::setDynamicClassname($title, ['Dashboard']);
  $categoryLinkStyling = Utilities::setDynamicClassname($title, ['Categories']);
  $shoeListLinkStyling = Utilities::setDynamicClassname($title, $shoeTitles);
  $orderLinkStyling = Utilities::setDynamicClassname($title, $orderTitles);
  $customerLinkStyling = Utilities::setDynamicClassname($title, $customerTitles);
  $reportLinkStyling = Utilities::setDynamicClassname($title, $reportTitles);
  $settingLinkStyling = Utilities::setDynamicClassname($title, ['Settings'])

?>

<aside>
  <div class="aside__logo">
    <img src="<?= SYSTEM_URL . 'public' ?>/icons/logo.svg" alt="logo">
    <p>Zapatos</p>

    <button type="button" class="aside__hide--btn"><i class="ri-arrow-left-s-line"></i></button>
  </div>

  <ul class="aside__menu">
    <li>
      <a href="<?= SYSTEM_URL . 'dashboard' ?>" class="aside__link <?= $dashboardLinkStyling ?>">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/dashboard.svg" alt="dashboard" class="aside__link--inactive">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/dashboard-bold.svg" alt="dashboard" class="aside__link--active">
        Dashboard
      </a>
    </li>
    <li>
      <a href="<?= SYSTEM_URL . 'categories' ?>" class="aside__link <?= $categoryLinkStyling ?>">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/category.svg" alt="category" class="aside__link--inactive">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/category-bold.svg" alt="category" class="aside__link--active">
        Categories
      </a>
    </li>
    <li>
      <a href="<?= SYSTEM_URL . 'admin/shoes/' ?>" class="aside__link <?= $shoeListLinkStyling ?>">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/product.svg" alt="products" class="aside__link--inactive">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/product-bold.svg" alt="products" class="aside__link--active">
        Shoes
      </a>
    </li>
    <li>
      <a href="<?= SYSTEM_URL . 'orders/' ?>" class="aside__link <?= $orderLinkStyling ?>">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/order.svg" alt="orders" class="aside__link--inactive">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/order-bold.svg" alt="orders" class="aside__link--active">
        Orders
      </a>
    </li>
    <li>
      <a href="<?= SYSTEM_URL . 'customers/' ?>" class="aside__link <?= $customerLinkStyling ?>">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/customer.svg" alt="customers" class="aside__link--inactive">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/customer-bold.svg" alt="customers" class="aside__link--active">
        Customers
      </a>
    </li>
    <li>
      <a href="<?= SYSTEM_URL . 'reports/' ?>" class="aside__link <?= $reportLinkStyling ?>">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/report.svg" alt="reports" class="aside__link--inactive">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/report-bold.svg" alt="reports" class="aside__link--active">
        Reports
      </a>
    </li>
    <li>
      <a href="<?= SYSTEM_URL . 'settings' ?>" class="aside__link <?= $settingLinkStyling ?>">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/setting.svg" alt="settings" class="aside__link--inactive">
        <img src="<?= SYSTEM_URL . 'public' ?>/icons/setting-bold.svg" alt="settings" class="aside__link--active">
        Settings
      </a>
    </li>
  </ul>

  <div class="aside__account">
    <div class="aside__profile">
      <img src="<?= SYSTEM_URL . 'public' ?>/images/customer-2.jpg" alt="profile">
      <div>
        <p>Jake Jennings</p>
        <p>Administrator</p>
      </div>
    </div>
  </div>
</aside>