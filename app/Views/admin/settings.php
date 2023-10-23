<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = 'Settings';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';

  $settings = $settingController->show();
  
?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content setting__content">
        <div class="settings__grid">
          <form autocomplete="off" class="settings__general" id="save-general-setting-form">
            <div class="settings__header">
              <div>
                <p>General</p>
                <p>Set up the business informations.</p>
              </div>
              <button type="submit" class="settings__form--submit" id="save-general-setting-btn">
                <i class="ri-checkbox-circle-fill"></i>
                Save
              </button>
            </div>

            <div class="settings__input">
              <div class="settings__input-icon">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/location.svg" alt="location">
              </div>
              <input type="text" name="address" placeholder="Business address" value="<?= isset($settings->address) ? $settings->address : '' ?>">
            </div>
            <div class="settings__input">
              <div class="settings__input-icon">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/setting-email.svg" alt="email">
              </div>
              <input type="text" name="email" placeholder="Business email address" value="<?= isset($settings->email) ? $settings->email : '' ?>">
            </div>
            <div class="settings__input">
              <div class="settings__input-icon">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/call.svg" alt="phone">
              </div>
              <input type="text" name="contact_number" placeholder="Business phone number" maxLength="11" value="<?= isset($settings->contact_number) ? $settings->contact_number : '' ?>">
            </div>
          </form>

          <form autocomplete="off" class="settings__general" id="save-security-setting-form">
            <div class="settings__header">
              <div>
                <p>Security</p>
                <p>Make your system secure.</p>
              </div>
              <button type="submit" class="settings__form--submit" id="save-security-setting-btn">
                <i class="ri-checkbox-circle-fill"></i>
                Change
              </button>
            </div>

            <div class="settings__input">
              <div class="settings__input-icon">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/key.svg" alt="password">
              </div>
              <input type="password" name="current_password" placeholder="Current password">
              <button type="button" class="password-show"><i class="ri-eye-fill"></i></button>
            </div>
            <div class="settings__input">
              <div class="settings__input-icon">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/key.svg" alt="password">
              </div>
              <input type="password" name="new_password" placeholder="New password">
              <button type="button" class="password-show"><i class="ri-eye-fill"></i></button>
            </div>
            <div class="settings__input">
              <div class="settings__input-icon">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/key.svg" alt="password">
              </div>
              <input type="password" name="confirm_password" placeholder="Confirm password">
              <button type="button" class="password-show"><i class="ri-eye-fill"></i></button>
            </div>
          </form>

          <div class="setting__socials">
            <div class="settings__header">
              <div>
                <p>Socials</p>
                <p>Set up your social media accounts.</p>
              </div>
            </div>

            <div class="socials__wrapper">
              <div class="settings__input">
                <div class="settings__input-icon">
                  <img src="<?= SYSTEM_URL . 'public' ?>/icons/facebook-gray.svg" alt="facebook">
                </div>
                <input type="text" placeholder="Enter the url">
                <button type="button" class="socials__save-button"><i class="ri-checkbox-circle-fill"></i></button>
              </div>
              <div class="settings__input">
                <div class="settings__input-icon">
                  <img src="<?= SYSTEM_URL . 'public' ?>/icons/instagram-gray.svg" alt="instagram">
                </div>
                <input type="text" placeholder="Enter the url">
                <button type="button" class="socials__save-button"><i class="ri-checkbox-circle-fill"></i></button>
              </div>
              <div class="settings__input">
                <div class="settings__input-icon">
                  <img src="<?= SYSTEM_URL . 'public' ?>/icons/whatsapp-gray.svg" alt="whatsapp">
                </div>
                <input type="text" placeholder="Enter the url">
                <button type="button" class="socials__save-button"><i class="ri-checkbox-circle-fill"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require_once 'app/Views/partials/_script.php' ?>