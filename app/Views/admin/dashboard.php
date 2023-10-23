<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = 'Dashboard';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';
  
?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content">
        <h1 class="main__content-heading">Good Morning <span>Jake</span>.</h1>
        <p class="main__content-subheading">Manage and monitor each transactions.</p>

        <div class="main__grid-cols-2">
          <div class="main__card-overview">
            <div class="main__card-grid">
              <div class="main__card">
                <div class="main_card-details">

                  <?php 
                    $totalSales = $orderController->getTotalSales();
                  ?>

                  <h2 class="main_card-count">₱<?= isset($totalSales->total_sales) ? Utilities::formatNumber($totalSales->total_sales) : 0 ?></h2>
                  <p>In total profit</p>
                  <p>Total Sales</p>
                </div>
                <div class="main__card-icon">
                  <img src="<?= SYSTEM_URL . 'public' ?>/icons/sales.svg" alt="product">
                </div>
              </div>
              <div class="main__card">
                <div class="main_card-details">

                  <?php 
                    $placedOrders = $orderController->show('Delivered');
                    $totalPlacedOrders = count($placedOrders);
                  ?>

                  <h2 class="main_card-count"><?= $totalPlacedOrders ?></h2>
                  <p>Placed orders</p>
                  <p>Total Orders</p>
                </div>
                <div class="main__card-icon">
                  <img src="<?= SYSTEM_URL . 'public' ?>/icons/order-black.svg" alt="product">
                </div>
              </div>
              <div class="main__card">
                <div class="main_card-details">

                  <?php 
                    $shoes = $shoeController->show();
                    $totalShoes = count($shoes);
                  ?>

                  <h2 class="main_card-count"><?= $totalShoes ?></h2>
                  <p>Shoe products</p>
                  <p>Total Shoes</p>
                </div>
                <div class="main__card-icon">
                  <img src="<?= SYSTEM_URL . 'public' ?>/icons/product-black.svg" alt="product">
                </div>
              </div>
              <div class="main__card">
                <div class="main_card-details">
                  <?php 
                    $brands = $brandController->show();
                    $categories = $categoryController->show();
                    $totalBrandAndCategories = count($brands) + count($categories);
                  ?>

                  <h2 class="main_card-count"><?= $totalBrandAndCategories ?></h2>
                  <p>Brands, categories</p>
                  <p>Category & Brands</p>
                </div>
                <div class="main__card-icon">
                  <img src="<?= SYSTEM_URL . 'public' ?>/icons/category-black.svg" alt="product">
                </div>
              </div>
            </div>
          </div>
          <div class="chart-wrapper">
            <p>Sales Statistics</p>
            <p>Visualize monthly sales this year</p>
            <div id="sales-stats"></div>
          </div>

          <div class="main__content-wrapper">
            <div class="main__header">
              <div>
                <p>Top Selling Shoes</p>
                <p>Top and hottest-selling shoes</p>
              </div>
            </div>

            <div class="table-responsive">
              <table>
                <thead>
                  <th>Shoe</th>
                  <th>Price</th>
                  <th>Percentage</th>
                  <th>Sales</th>
                </thead>
                <tbody>

                  <?php 
                    $maxTopSellingDisplayRecord = 5;
                    $topSellingShoes = $orderItemController->showTopSelling();

                    for ($topSellingIndex = 0; $topSellingIndex < $maxTopSellingDisplayRecord; $topSellingIndex++) :
                      if (isset($topSellingShoes[$topSellingIndex])) :
                        $shoeSales = $topSellingShoes[$topSellingIndex]->shoe_price * $topSellingShoes[$topSellingIndex]->quantity;
                        $salePercentage = Utilities::calculatePercentage($shoeSales, $totalSales->total_sales);
                        $shoeMainColor = $colorController->showOne($topSellingShoes[$topSellingIndex]->shoe_id);
                        $shoeMainImage = $shoeImageController->showOne($shoeMainColor->color_id);
                  ?>

                        <tr>
                          <td>
                            <div class="table__shoes">
                              <div class="table__shoe-image">
                                <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeMainImage->shoe_image_id . $shoeMainImage->extension ?>" alt="<?= $topSellingShoes[$topSellingIndex]->shoe_name ?>">
                              </div>
                              <div>
                                <p><?= $topSellingShoes[$topSellingIndex]->shoe_name ?></p>
                                <p><?= $topSellingShoes[$topSellingIndex]->brand_name ?></p>
                              </div>
                            </div>
                          </td>
                          <td>₱<?= number_format($topSellingShoes[$topSellingIndex]->shoe_price) ?></td>
                          <td>
                            <div class="table__percentage">
                              <div class="table__percentage-bar" style="width: <?= $salePercentage ?>; color: #fff;"><?= $salePercentage ?></div>
                            </div>
                          </td>
                          <td>₱<?= Utilities::formatNumber($shoeSales) ?></td>
                        </tr>

                  <?php 
                      else :
                  ?>

                        <tr>
                          <td>
                            <div class="table__shoes">
                              <div class="table__shoe-image skeleton">
                                
                              </div>
                              <div>
                                <div style="width: 85px; height: 10px; background-color: #f7f8fa; margin-bottom: 4px; border-radius: 100px;"></div>
                                <div style="width: 35px; height: 8px; background-color: #f7f8fa; border-radius: 100px;"></div>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div style="width: 40px; height: 10px; background-color: #f7f8fa; border-radius: 100px;"></div>
                          </td>
                          <td>
                            <div class="table__percentage skeleton"></div>
                          </td>
                          <td>
                            <div style="width: 40px; height: 10px; background-color: #f7f8fa; border-radius: 100px;"></div>
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

          <div class="main__content-wrapper">
            <div class="main__header">
              <div>
                <p>Recent Added Shoes</p>
                <p>New arrival shoes</p>
              </div>
              <a href="<?= SYSTEM_URL . 'admin/shoes/' ?>">See All</a>
            </div>

            <div class="table-responsive">
              <table>
                <thead>
                  <th>Shoe</th>
                  <th>Price</th>
                  <th>Colors</th>
                  <th>Stocks</th>
                </thead>
                <tbody>

                  <?php 
                    $maxRecentAddedShoeRecord = 5;
                    $newAddedShoes = $shoeController->show();

                    for ($recentShoeIndex = 0; $recentShoeIndex < $maxRecentAddedShoeRecord; $recentShoeIndex++) :
                      if (isset($newAddedShoes[$recentShoeIndex])) :
                        $shoeColors = $colorController->show($newAddedShoes[$recentShoeIndex]->shoe_id);
                        $shoeMainImage = $shoeImageController->showOne($shoeColors[0]->color_id);
                  ?>

                        <tr>
                          <td>
                            <div class="table__shoes">
                              <div class="table__shoe-image">
                                <img src="<?= SYSTEM_URL . 'uploads/shoes/' . $shoeMainImage->shoe_image_id . $shoeMainImage->extension ?>" alt="<?= $newAddedShoes[$recentShoeIndex]->shoe_name ?>">
                              </div>
                              <div>
                                <p><?= $newAddedShoes[$recentShoeIndex]->shoe_name ?></p>
                                <p><?= $newAddedShoes[$recentShoeIndex]->brand_name ?></p>
                              </div>
                            </div>
                          </td>
                          <td>₱<?= number_format($newAddedShoes[$recentShoeIndex]->shoe_price) ?></td>
                          <td>
                            <div class="table__colors">

                              <?php 
                                foreach ($shoeColors as $shoeColor) :
                              ?>

                                  <span style="background-color: <?= $shoeColor->color_hex ?>"></span>

                              <?php 
                                endforeach
                              ?>

                            </div>
                          </td>
                          <td><?= $newAddedShoes[$recentShoeIndex]->shoe_stocks ?></td>
                        </tr>

                  <?php 
                      else :
                  ?>

                        <tr>
                          <td>
                            <div class="table__shoes">
                              <div class="table__shoe-image skeleton">
                              </div>
                              <div>
                                <div style="width: 85px; height: 10px; background-color: #f7f8fa; margin-bottom: 4px; border-radius: 100px;"></div>
                                <div style="width: 35px; height: 8px; background-color: #f7f8fa; border-radius: 100px;"></div>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div style="width: 40px; height: 10px; background-color: #f7f8fa; border-radius: 100px;"></div>
                          </td>
                          <td>
                            <div class="table__colors">
                              <span class="skeleton"></span>
                              <span class="skeleton"></span>
                              <span class="skeleton"></span>
                            </div>
                          </td>
                          <td>
                            <div style="width: 40px; height: 10px; background-color: #f7f8fa; border-radius: 100px;"></div>
                          </td>
                        </tr>

                  <?php 
                      endif;
                    endfor
                  ?>
                  
                </tbody>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="main__grid-cols-3">
          <div class="chart-wrapper">
            <div class="main__header">
              <div>
                <p>Shoe Brands</p>
                <p>Shoes statistic in each brands</p>
              </div>
              <a href="<?= SYSTEM_URL . 'categories' ?>">See All</a>
            </div>
            
            <div id="brand-stats"></div>

            <div class="main__brand-chart-legend">
              <div class="main__brand-legend">
                <span></span>
                <p>Nike</p>
              </div>
              <div class="main__brand-legend">
                <span></span>
                <p>Adidas</p>
              </div>
              <div class="main__brand-legend"> 
                <span></span>
                <p>Puma</p>
              </div>
              <div class="main__brand-legend">
                <span></span>
                <p>Skechers</p>
              </div>
              <div class="main__brand-legend">
                <span></span>
                <p>Fila</p>
              </div>
            </div>
          </div>

          <div class="main__content-wrapper main__recent-order">
            <div class="main__header">
              <div>
                <p>Recent Orders</p>
                <p>Recently placed orders</p>
              </div>
              <a href="<?= SYSTEM_URL . 'orders/' ?>">See All</a>
            </div>

            <div class="table-responsive">
              <table>
                <thead>
                  <th>Order No</th>
                  <th>Customer</th>
                  <th>Amount</th>
                  <th>MOP</th>
                  <th>Status</th>
                </thead>
                <tbody>

                  <?php 
                    $maxRecentOrderRecord = 2;
                    $recentOrders = $orderController->show();

                    for ($recentOrderIndex = 0; $recentOrderIndex < $maxRecentOrderRecord; $recentOrderIndex++) :
                      if (isset($recentOrders[$recentOrderIndex])) :
                  ?>

                        <tr>
                          <td><?= $recentOrders[$recentOrderIndex]->order_no ?></td>
                          <td>
                            <div class="table__customer">
                              <div class="table__customer-acronym">
                                <?= !empty($recentOrders[$recentOrderIndex]->fullname) ? substr($recentOrders[$recentOrderIndex]->fullname, 0, 1) : 'Z' ?>
                              </div>
                              <div>
                                <p><?= !empty($recentOrders[$recentOrderIndex]->fullname) ? $recentOrders[$recentOrderIndex]->fullname : 'Zapatos User' ?></p>
                                <p>Customer</p>
                              </div>
                            </div>
                          </td>
                          <td>₱<?= $recentOrders[$recentOrderIndex]->order_amount ?></td>
                          <td><?= $recentOrders[$recentOrderIndex]->order_mop ?></td>
                          <td>
                            <span class="table__order-status <?= strtolower($recentOrders[$recentOrderIndex]->order_status) ?>"><?= $recentOrders[$recentOrderIndex]->order_status ?></span>
                          </td>
                        </tr>

                  <?php 
                      else :
                  ?>

                        <tr>
                          <td>
                            <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
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
                        </tr>

                  <?php 
                      endif;
                    endfor
                  ?>
                  
                </tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require_once 'app/Views/partials/_script.php' ?>