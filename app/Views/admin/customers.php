<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = isset($type) ? ucwords(str_replace('-', ' ', $type)) : 'Customers';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';
  require_once 'app/Views/partials/_dialog.php';

  $customerParams = $title === 'Customers' ? '' : $title;
  $customers = $customerController->show($customerParams);
  
?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content">
        <div class="main__content-header">
          <div>
            <h1 class="main__content-heading">Customers</h1>
            <p class="main__content-subheading">Manage customer accounts.</p>
          </div>
        </div>

        <div class="main__filter-wrapper">
          <div class="main__tabs">
            <a href="<?= SYSTEM_URL . 'customers/' ?>" class="<?= Utilities::setDynamicClassname($title, ['Customers']) ?>">All</a>
            <a href="<?= SYSTEM_URL . 'customers/active' ?>" class="<?= Utilities::setDynamicClassname($title, ['Active']) ?>">Active</a>
            <a href="<?= SYSTEM_URL . 'customers/deactivated' ?>" class="<?= Utilities::setDynamicClassname($title, ['Deactivated']) ?>">Deactivated</a>
          </div>
        </div>

        <div class="main__order-list">
          <div class="table-responsive">
            <table>
              <thead>
                <th>Customer</th>
                <th>Contact</th>
                <th>Street</th>
                <th>Zone</th>
                <th>Barangay</th>
                <th>Municipality</th>
                <th>Province</th>
                <th>Status</th>
                <th>Action</th>
              </thead>
              <tbody>

                <?php 
                  $customerPlaceholderCount = 8;
                  $totalCustomerCount = count($customers);
                  $maxCustomerRecords = $totalCustomerCount > $customerPlaceholderCount ? $totalCustomerCount : $customerPlaceholderCount;

                  for ($customerIndex = 0; $customerIndex < $maxCustomerRecords; $customerIndex++) :
                    if (isset($customers[$customerIndex])) :
                ?>

                      <tr class="search-area">
                        <td>
                          <div class="table__customer">
                            <div class="table__customer-acronym">
                              <?= !empty($customers[$customerIndex]->fullname) ? substr($customers[$customerIndex]->fullname, 0, 1) : 'Z' ?>
                            </div>
                            <div>
                              <p class="finder1"><?= !empty($customers[$customerIndex]->fullname) ? $customers[$customerIndex]->fullname : 'Zapatos User' ?></p>
                              <p class="finder2"><?= $customers[$customerIndex]->email ?></p>
                            </div>
                          </div>
                        </td>
                        <td class="finder3">
                          <?= isset($customers[$customerIndex]->contact_number) ? $customers[$customerIndex]->contact_number : 'Not Set' ?>
                        </td>
                        <td class="finder4">
                          <?= isset($customers[$customerIndex]->street) ? $customers[$customerIndex]->street : 'Not Set' ?>
                        </td>
                        <td class="finder5">
                          <?= isset($customers[$customerIndex]->zone) ? $customers[$customerIndex]->zone : 'Not Set' ?>
                        </td>
                        <td class="finder6">
                          <?= isset($customers[$customerIndex]->barangay) ? $customers[$customerIndex]->barangay : 'Not Set' ?>
                        </td>
                        <td class="finder7">
                          <?= isset($customers[$customerIndex]->municipality) ? $customers[$customerIndex]->municipality . ', ' . $customers[$customerIndex]->zip_code : 'Not Set' ?>
                        </td>
                        <td class="finder8">
                          <?= isset($customers[$customerIndex]->province) ? $customers[$customerIndex]->province : 'Not Set' ?>
                        </td>
                        <td>
                          <span class="finder9 table__account-status <?= $customers[$customerIndex]->is_active == 1 ? 'active' : 'deactivated' ?>">
                          <?= $customers[$customerIndex]->is_active == 1 ? 'Active' : 'Deactivated' ?>
                          </span>
                        </td>
                        <td width="10%">

                          <?php
                            $btnTarget = isset($customers[$customerIndex]->fullname) ? $customers[$customerIndex]->fullname : 'Zapatos User';
                            $btnTitle = $customers[$customerIndex]->is_active == 1 ? 'Deactivate Account' : 'Activate Account';
                            $btnIcon = $customers[$customerIndex]->is_active == 1 ? 'ri-close-circle-fill' : 'ri-checkbox-circle-fill';
                          ?>

                          <button type="button" class="table__button account-action--btn" title="<?= $btnTitle ?>" data-target="<?= $btnTarget ?>" data-value="<?= $customers[$customerIndex]->account_id ?>">
                            <i class="<?= $btnIcon ?>"></i>
                          </button>
                          
                        </td>
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