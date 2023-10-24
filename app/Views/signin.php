<?php

  require_once __DIR__.'/../../config/init.php';

  use App\Utils\Utilities;

  Utilities::isAccountUnderVerification();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  } else {
    Utilities::redirectAuthorize('dashboard');
  }
  
  $title = 'Sign In';

  require_once 'partials/_header.php';
  require_once 'partials/_loader.php';
  require_once 'partials/_toast.php';
  
?>

  <main class="account">
    <div class="account__form-wrapper">
      <a href="<?= SYSTEM_URL ?>" class="account__home-link">Zapatos</a>

      <p class="account__heading">Sign In to Your Account</p>
      <p class="account__subheading">Access your profile and enjoy a seamless shopping experience</p>

      <div class="account__toggler">
        <button type="button" class="account__signin--btn">Sign In</button>
        <button type="button" class="account__signup--btn">Sign Up</button>
      </div>

      <div class="account__signin-form">
        <div id="g_id_onload" data-client_id="156367368299-n08kp2i2e3rgnbprgjpgauctm53ubg8p.apps.googleusercontent.com" data-ux_mode="redirect" data-login_uri="<?= SYSTEM_URL . 'app/Jobs/process_google_signin.php' ?>">
        </div>
        <div class="account__google--btn">
          <button class="g_id_signin" data-shape="pill" data-type="standard"></button>
          <div class="account__google-overlay">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/google.svg" alt="google">
            Sign in with Google
          </div>
        </div>

        <div class="account__seperator">
          <p>Or Sign In With Email</p>
          <hr>
        </div>

        <form autocomplete="off" id="signin-form">
          <div class="account__form-group">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/email.svg" alt="email">
            <hr>
            <input type="text" name="email" placeholder="Enter your email">
          </div>
          <div class="account__form-group">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/password.svg" alt="password">
            <hr>
            <input type="password" name="password" placeholder="Account password">
            <button type="button" class="password-show"><i class="ri-eye-fill"></i></button>
          </div>
          <button type="submit" class="account__form--submit" id="signin-btn">
            <div class="spinner"></div>
            Sign In
          </button>
        </form>
      </div>

      <div class="account__signup-form">
        <div class="account__google--btn">
          <button class="g_id_signin" id="google-btn" data-shape="pill" data-type="standard"></button>
          <div class="account__google-overlay">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/google.svg" alt="google">
            Sign up with Google
          </div>
        </div>

        <div class="account__seperator">
          <p>Or Sign Up With Email</p>
          <hr>
        </div>

        <form autocomplete="off" id="signup-form">
          <div class="account__form-group">
            <img src="<?= SYSTEM_URL . 'public' ?>/icons/email.svg" alt="email">
            <hr>
            <input type="email" name="email" placeholder="Enter your email">
          </div>
          <div class="account__form-grid">
            <div class="account__form-group">
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/password.svg" alt="password">
              <hr>
              <input type="password" name="password" placeholder="Account password">
              <button type="button" class="password-show"><i class="ri-eye-fill"></i></button>
            </div>
            <div class="account__form-group">
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/password.svg" alt="password">
              <hr>
              <input type="password" name="confirm_password" placeholder="Confirm password">
              <button type="button" class="password-show"><i class="ri-eye-fill"></i></button>
            </div>
          </div>
          <button type="submit" class="account__form--submit" id="signup-btn">
            <div class="spinner"></div>
            Sign Up
          </button>
        </form>
      </div>
    </div>

    <div class="account__image">
      <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-10.webp" alt="shoe">
    </div>
  </main>

<?php require_once 'partials/_script.php' ?>