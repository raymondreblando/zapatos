<?php

  require_once __DIR__.'/../../config/init.php';

  use App\Utils\Utilities;

  Utilities::isAccountNotUnderVerification();
  
  $title = 'Email Verify';

  require_once 'partials/_header.php';
  require_once 'partials/_loader.php';
  require_once 'partials/_toast.php';

  $type = Utilities::sanitize($type);
  $token = Utilities::sanitize($token);
  
?>

  <main class="account">
    <div class="account__verification">
      
      <?php 
        if ($type === 'success') : 
      ?>

          <img src="<?= SYSTEM_URL . 'public' ?>/icons/email-verify.svg" alt="email verify" class="account__email-sent">

          <p class="account__verify-heading">Your email has been verified</p>
          <p class="account__verify-subheading">Congratulations! Your email address has been successfully verified. You now have <br> full access to your account and can enjoy a seamless shopping experience.</p>

          <button type="button" class="account_email--btn email-verify">Login Now</button>

      <?php 
        else :
      ?>

          <img src="<?= SYSTEM_URL . 'public' ?>/icons/email-error.svg" alt="verification error" class="account__email-sent">
    
          <p class="account__verify-heading">Your email has not been verified</p>
          <p class="account__verify-subheading">We apologize, but it seems the verification link has expired. To complete your registration, please request a new verification email by clicking the "Resend Verification Email" button below.</p>
    
          <button type="button" class="account_email--btn email-notverify" data-value="<?= $token ?>">Resend Verification Email</button>

      <?php 
        endif;
      ?>
      
    </div>
  </main>

<?php require_once 'partials/_script.php' ?>