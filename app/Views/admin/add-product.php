<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = 'Add New Shoe';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';
  
?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content">
        <div class="main__breadcrumbs-wrapper">
          <a href="<?= SYSTEM_URL . 'admin/shoes/' ?>" class="main__breadcrumbs">Shoes</a>
          <span><i class="ri-arrow-right-s-line"></i></span>
          <a href="<?= SYSTEM_URL . 'shoe/add' ?>" class="main__breadcrumbs active">New Shoe</a>
        </div>

        <form autocomplete="off" id="save-shoe-form" enctype="multipart/form-data">
          <div class="main__content-header">
            <div>
              <h1 class="main__content-heading">Add New Shoe</h1>
              <p class="main__content-subheading">Add new shoe in the collections.</p>
            </div>
            <button type="submit" class="main__create" id="save-shoe-btn">
              <div class="spinner"></div>
              Save
            </button>
          </div>

          <div class="main__formdata">
            <div class="main__formdata-grid-3">
              <div class="main__formdata-wrapper">
                <label for="description">Upload Default Shoe Images</label>
                <div class="formdata__upload-grid">

                  <?php 
                    for ($uploadInputIndex = 0; $uploadInputIndex < 6; $uploadInputIndex++) :
                  ?>

                    <div class="formdata__upload">
                      <input type="file" name="shoe_image[]" class="upload-input" hidden>
                      <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-1.png" alt="shoe" class="upload-preview" hidden>
                      <div class="upload-icon">
                        <i class="ri-upload-cloud-2-line"></i>
                        <p>Upload Image</p>
                      </div>
                    </div>
                  
                  <?php 
                    endfor 
                  ?>
                  
                </div>
              </div>

              <div class="main__formdata-wrapper">
                <div class="formdata__grid-cols-2">
                  <div class="span-2">
                    <label for="shoe_name">Shoe Name</label>
                    <input type="text" name="shoe_name" placeholder="Enter shoe name">
                  </div>
                  <div>
                    <label for="price">Shoe Price</label>
                    <input type="text" name="price" placeholder="Enter shoe price">
                  </div>
                  <div>
                    <label for="stocks">Shoe Stocks</label>
                    <input type="text" name="stocks" placeholder="Enter avaiable stocks">
                  </div>
                  <div>
                    <label for="categorize_as">Categorize as</label>

                    <?php 
                      $categorizeOptions = ['Men', 'Women', 'Unisex', 'Kids'];
                    ?>

                    <select name="categorize_as">
                      <option value="">Select</option>

                        <?php foreach ($categorizeOptions as $categorizeOption) : ?>

                          <option value="<?= $categorizeOption ?>"><?= $categorizeOption ?></option>

                      <?php endforeach ?>

                    </select>
                  </div>
                  <div>
                    <label for="brand">Brand</label>
                    <select name="brand">
                      <option value="">Select Brand</option>

                      <?php foreach($brandController->show() as $brand): ?>

                        <option value="<?= $brand->brand_id ?>"><?= $brand->brand_name ?></option>

                      <?php endforeach ?>

                    </select>
                  </div>
                  <div>
                    <label for="category">Category</label>
                    <select name="category">
                      <option value="">Select Category</option>

                      <?php foreach($categoryController->show() as $category): ?>

                        <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>

                      <?php endforeach ?>

                    </select>
                  </div>
                  <div>
                    <label for="discount">Discount</label>
                    <input type="text" name="discount" placeholder="Enter shoe discount" value="0%">
                  </div>
                  <div class="span-2">
                    <label for="description">Shoe Description</label>
                    <textarea name="description" placeholder="Enter shoe description"></textarea>
                  </div>
                </div>
              </div>

              <div class="main__formdata-wrapper">
                <div class="formdata__header">
                  <label for="description">Select Shoe Sizes</label>
                  <button type="button" class="formdata__size--toggle-btn">Toggle All</button>
                </div>
                <div class="formdata__size-wrapper">
                   
                  <?php 
                    $defaultShoeSizes = [2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 12, 13];
                    foreach ($defaultShoeSizes as $defaultSize) :
                  ?>

                    <span type="button" class="formdata__tickbox" data-value="<?=$defaultSize ?>"><?=$defaultSize ?></span>

                  <?php 
                    endforeach 
                  ?>
                  
                </div>
                <div class="formdata__header">
                  <label for="description">Shoe Colors</label>
                  <button type="button" class="formdata__add--btn">Add Color</button>
                </div>
                <div class="formdata__color-grid">
                  <div class="formdata__color">
                    <span></span>
                    <input type="text" name="colors[]" class="formdata__color-input" placeholder="HEX Code">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

    </section>
  </main>

<?php require_once 'app/Views/partials/_script.php' ?>