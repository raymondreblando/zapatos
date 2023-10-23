<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = 'Update Shoe Details';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';

  $shoeId = Utilities::sanitize($id);
  $shoeDetails = $shoeController->showOne($shoeId);
  
?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content">
        <div class="main__breadcrumbs-wrapper">
          <a href="<?= SYSTEM_URL . 'admin/shoes/' ?>" class="main__breadcrumbs">Shoes</a>
          <span><i class="ri-arrow-right-s-line"></i></span>
          <a href="<?= SYSTEM_URL . 'shoe/update/' . $shoeId ?>" class="main__breadcrumbs active">Update Shoe</a>
        </div>

        <form autocomplete="off" id="update-shoe-form">
          <div class="main__content-header">
            <div>
              <h1 class="main__content-heading">Update Shoe Details</h1>
              <p class="main__content-subheading">Update shoe stocks and available colors.</p>
            </div>
            <button type="submit" data-value="<?= $shoeId ?>" class="main__create" id="update-shoe-btn">
              <div class="spinner"></div>
              Save
            </button>
          </div>

          <div class="main__formdata">
            <div class="main__formdata-grid-2">
              <div class="main__formdata-wrapper">
                <div class="formdata__grid-cols-2">
                  <div class="span-2">
                    <label for="shoe_name">Shoe Name</label>
                    <input type="text" name="shoe_name" placeholder="Enter shoe name" value="<?= $shoeDetails->shoe_name ?>">
                  </div>
                  <div>
                    <label for="price">Shoe Price</label>
                    <input type="text" name="price" placeholder="Enter shoe price" value="<?= $shoeDetails->shoe_price ?>">
                  </div>
                  <div>
                    <label for="stocks">Shoe Stocks</label>
                    <input type="text" name="stocks" placeholder="Enter avaiable stocks" value="<?= $shoeDetails->shoe_stocks ?>">
                  </div>
                  <div>
                    <label for="categorize_as">Categorize as</label>

                    <?php 
                      $categorizeOptions = ['Men', 'Women', 'Unisex', 'Kids'];
                    ?>

                    <select name="categorize_as">
                      <option value="">Select</option>

                      <?php foreach ($categorizeOptions as $categorizeOption) : ?>

                        <option value="<?= $categorizeOption ?>" <?= $categorizeOption === $shoeDetails->shoe_categorize_as ? 'selected' : '' ?>><?= $categorizeOption ?></option>

                      <?php endforeach ?>

                    </select>
                  </div>
                  <div>
                    <label for="brand">Brand</label>
                    <select name="brand">
                      <option value="">Select Brand</option>

                      <?php foreach($brandController->show() as $brand): ?>

                        <option value="<?= $brand->brand_id ?>" <?= $brand->brand_id === $shoeDetails->brand_id ? 'selected' : '' ?>><?= $brand->brand_name ?></option>

                      <?php endforeach ?>

                    </select>
                  </div>
                  <div>
                    <label for="category">Category</label>
                    <select name="category">
                      <option value="">Select Category</option>

                      <?php foreach($categoryController->show() as $category): ?>

                        <option value="<?= $category->category_id ?>" <?= $category->category_id === $shoeDetails->category_id ? 'selected' : '' ?>><?= $category->category_name ?></option>

                      <?php endforeach ?>

                    </select>
                  </div>
                  <div>
                    <label for="discount">Discount</label>
                    <input type="text" name="discount" placeholder="Enter shoe discount" value="<?= $shoeDetails->shoe_discount ?>">
                  </div>
                  <div class="span-2">
                    <label for="description">Shoe Description</label>
                    <textarea name="description" placeholder="Enter shoe description"><?= $shoeDetails->shoe_description ?></textarea>
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
                  $shoeSizes = $sizeController->show($shoeId);
                  $shoeAvailableSizes = array_column($shoeSizes, 'size');
                ?>

                  <?php foreach ($defaultShoeSizes as $index => $defaultSize) : ?>

                    <span type="button" class="formdata__tickbox formdata__update-tickbox <?= in_array($defaultSize, $shoeAvailableSizes) ? 'selected' : '' ?>" data-value="<?= $shoeSizes[$index]->size_id ?>"><?= $defaultSize ?></span>

                  <?php endforeach ?>
                  
                </div>
                <div class="formdata__header">
                  <label for="description">Shoe Colors</label>
                  <button type="button" class="formdata__add--btn">Add Color</button>
                </div>
                <div class="formdata__color-grid">

                  <?php 
                    $shoeColors = $colorController->show($shoeId);
                    foreach ($shoeColors as $shoeColor) :
                  ?>

                    <div class="formdata__color">
                      <span style="background-color: <?= $shoeColor->color_hex ?>;"></span>
                      <input type="text" name="colors[]" class="formdata__color-input" placeholder="HEX Code" value="<?= $shoeColor->color_hex ?>">
                    </div>

                  <?php 
                    endforeach 
                  ?>

                </div>
              </div>
            </div>
          </div>
        </form>

        <div class="main__formdata" style="margin-top: 12px;">
          <div class="main__formdata-grid-2">

            <?php 
              foreach ($shoeColors as $shoeColor) : 
                $shoeColorImages = $shoeImageController->show($shoeColor->color_id);
                $shoeImagesCount = count($shoeColorImages);
            ?>

              <form autocomplete="off" class="main__formdata-wrapper shoe__image-form" enctype="multipart/form-data">
                <div class="formdata__header">
                  <div>
                    <label for="shoe_color">Shoe Images for Color</label>
                    <span style="background-color: <?= $shoeColor->color_hex ?>"></span>
                    <label for="color_hex" style="color: <?= $shoeColor->color_hex ?>;text-transform: uppercase"><?= $shoeColor->color_hex ?></label>
                  </div>

                  <?php if ($shoeImagesCount > 0) : ?>

                    <button type="button" data-value="<?= $shoeColor->color_id ?>" class="formdata__size--toggle-btn update__color-status">Set color <?= $shoeColor->color_status === 'Available' ? 'unavailable' : 'available' ?></button>
                    
                  <?php else : ?>
                      
                    <button type="submit" data-value="<?= $shoeColor->color_id ?>" class="formdata__size--toggle-btn save-shoe-image__btn">Save</button>

                  <?php endif ?>
                </div>

                <div class="showcase__grid">

                  <?php  
                    if ($shoeImagesCount > 0) :
                      foreach ($shoeColorImages as $shoeImage) :
                  ?>

                    <div class="formdata__upload">
                      <input type="file" name="shoe_image[]" class="upload-input" hidden>
                      <img src="<?= SYSTEM_URL . 'uploads/shoes/'. $shoeImage->shoe_image_id . $shoeImage->extension ?>" alt="shoe" class="upload-preview">
                    </div>

                  <?php 
                      endforeach;
                    else :
                      $shoeUploadInputCount = 6;
                      for ($uploadIndex = 0; $uploadIndex < 6; $uploadIndex++) :
                  ?>

                    <div class="formdata__upload">
                      <input type="file" name="shoe_image[]" class="upload-input" hidden>
                      <img src="" alt="shoe" class="upload-preview" hidden>
                      <div class="upload-icon">
                        <i class="ri-upload-cloud-2-line"></i>
                        <p>Upload Image</p>
                      </div>
                    </div>

                  <?php 
                      endfor;
                    endif
                  ?>
                  
                </div>
              </form>

            <?php 
              endforeach 
            ?>
            
          </div>
        </div>
      </div>

    </section>
  </main>

<?php require_once 'app/Views/partials/_script.php' ?>