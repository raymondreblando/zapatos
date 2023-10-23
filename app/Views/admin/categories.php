<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = 'Categories';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';
  
?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content">
        <h1 class="main__content-heading">Brands & Categories</h1>
        <p class="main__content-subheading">Manage brands and categories.</p>

        <div class="main__grid-cols-2">
          <div class="main__content-wrapper category">
            <div class="main__content-form">
              <form autocomplete="off" class="main__category-form" id="save-brand-form">
                <div class="main__form-group">
                  <img src="<?= SYSTEM_URL . 'public' ?>/icons/category-outline.svg" alt="category">
                  <input type="text" name="brand_name" placeholder="Enter brand name">
                </div>
                <button type="submit" class="main__submit--btn" id="save-brand-btn">
                  <div class="spinner"></div>
                  Save
                </button>
              </form>
            </div>

            <div class="main__header">
              <div>
                <p>Brand List</p>
                <p>Zapatos shoe brands</p>
              </div>

              <div class="main__pagination">
                <button type="button" class="main__pagination--prev-btn"><i class="ri-arrow-left-s-line"></i></button>

                <div class="main__pagination-page">
                  <p class="main__pagination-current">1</p>
                  <p class="main__pagination-separator">out</p>
                  <p class="main__pagination-total">100</p>
                </div>

                <button type="button" class="main__pagination--next-btn"><i class="ri-arrow-right-s-line"></i></button>
              </div>
            </div>

            <div class="table-responsive">
              <table>
                <thead>
                  <th>Brand</th>
                  <th>Shoe Count</th>
                  <th>Date Added</th>
                  <th>Sales</th>
                </thead>
                <tbody>

                  <?php  
                    $brandsPlaceholderCount = 6;
                    $shoeBrands = $brandController->show();
                    $maxBrandRecordCount = count($shoeBrands) > $brandsPlaceholderCount ? count($shoeBrands) : $brandsPlaceholderCount;
                    for($index = 0; $index < $maxBrandRecordCount; $index++):
                  ?>

                      <?php if (!empty($shoeBrands[$index])) : ?>

                        <tr>
                          <td>
                            <div class="table__shoes">
                              <div>
                                <p><?= $shoeBrands[$index]->brand_name ?></p>
                                <p>Shoe brand</p>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="table__percentage">
                              <div class="table__percentage-bar" style="width: 75%"></div>
                            </div>
                          </td>
                          <td><?= Utilities::formatDate($shoeBrands[$index]->date_created, 'm-d-Y') ?></td>
                          <td>₱30k</td>
                        </tr>

                      <?php else: ?>

                        <tr>
                          <td>
                            <div class="table__shoes">
                              <div>
                                <div style="width: 85px; height: 13px; background-color: #f7f8fa; margin-bottom: 6px; border-radius: 100px;"></div>
                                <div style="width: 35px; height: 10px; background-color: #f7f8fa; border-radius: 100px;"></div>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="table__percentage skeleton"></div>
                          </td>
                          <td>
                            <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                          </td>
                          <td>
                            <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                          </td>
                        </tr>

                      <?php endif ?>

                  <?php 
                    endfor 
                  ?>

                </tbody>
              </table>
            </div>
          </div>

          <div class="main__content-wrapper category">
            <div class="main__content-form">
              <form autocomplete="off" class="main__category-form" id="save-category-form">
                <div class="main__form-group">
                  <img src="<?= SYSTEM_URL . 'public' ?>/icons/category-outline.svg" alt="category">
                  <input type="text" name="category_name" placeholder="Enter category name">
                </div>
                <button type="submit" class="main__submit--btn" id="save-category-btn">
                  <div class="spinner"></div>
                  Save
                </button>
              </form>
            </div>

            <div class="main__header">
              <div>
                <p>Category List</p>
                <p>Zapatos shoe categories</p>
              </div>

              <div class="main__pagination">
                <button type="button" class="main__pagination--prev-btn"><i class="ri-arrow-left-s-line"></i></button>

                <div class="main__pagination-page">
                  <p class="main__pagination-current">1</p>
                  <p class="main__pagination-separator">out</p>
                  <p class="main__pagination-total">100</p>
                </div>

                <button type="button" class="main__pagination--next-btn"><i class="ri-arrow-right-s-line"></i></button>
              </div>
            </div>

            <div class="table-responsive">
              <table>
                <thead>
                  <th>Category</th>
                  <th>Shoe Count</th>
                  <th>Date Added</th>
                  <th>Sales</th>
                </thead>
                <tbody>
                  
                  <?php  
                    $categoriesPlaceholderCount = 6;
                    $shoeCategories = $categoryController->show();
                    $maxCategoryRecordCount = count($shoeCategories) > $categoriesPlaceholderCount ? count($shoeCategories) : $categoriesPlaceholderCount;
                    for($index = 0; $index < $maxCategoryRecordCount; $index++):
                  ?>

                      <?php if (!empty($shoeCategories[$index])) : ?>

                        <tr>
                          <td>
                            <div class="table__shoes">
                              <div>
                                <p><?= $shoeCategories[$index]->category_name ?></p>
                                <p>Shoe category</p>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="table__percentage">
                              <div class="table__percentage-bar" style="width: 75%"></div>
                            </div>
                          </td>
                          <td><?= Utilities::formatDate($shoeCategories[$index]->date_created, 'm-d-Y') ?></td>
                          <td>₱30k</td>
                        </tr>

                      <?php else: ?>

                        <tr>
                          <td>
                            <div class="table__shoes">
                              <div>
                                <div style="width: 85px; height: 13px; background-color: #f7f8fa; margin-bottom: 6px; border-radius: 100px;"></div>
                                <div style="width: 35px; height: 10px; background-color: #f7f8fa; border-radius: 100px;"></div>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="table__percentage skeleton"></div>
                          </td>
                          <td>
                            <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                          </td>
                          <td>
                            <div style="width: 40px; height: 13px; background-color: #f7f8fa; border-radius: 100px;"></div>
                          </td>
                        </tr>

                      <?php endif ?>

                  <?php 
                    endfor 
                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </section>
  </main>

<?php require_once 'app/Views/partials/_script.php' ?>