<?php

  require_once __DIR__.'/../../config/init.php';

  use App\Utils\Utilities;

  Utilities::isAccountNotUnderVerification();
  
  $title = 'Email Verification';

  require_once 'partials/_header.php';
  require_once 'partials/_loader.php';
  require_once 'partials/_toast.php';

  $accountId = $_SESSION['email_uid'];
  $selectAccountQuery = 'SELECT * FROM accounts WHERE account_id = ?';
  $helper->query($selectAccountQuery, [$accountId]);
  $accountData = $helper->fetch();
  
?>

  <main class="account">
    <div class="account__verification">
      <a href="index.html" class="account__home-link">Zapatos</a>

      <p class="account__heading">Confirm Your Email Address</p>
      <p class="account__subheading">Confirm Your Email Address</p>

      <img src="<?= SYSTEM_URL . 'public' ?>/icons/email-sent.svg" alt="email sent" class="account__email-sent">

      <p class="account__user-email">A verification link was sent to <span><?= $accountData->email ?></span></p>

      <p class="account__description">Thank you for signing up! To activate your account and enjoy all the benefits, please check your email for a verification link. Click the link to verify your email address and complete the registration process. If you don't receive the email within a few minutes, please check your spam folder or request a new verification email. Welcome to our community!</p>
    </div>

    <div class="account__image">
      <img src="<?= SYSTEM_URL . 'public' ?>/images/shoe-10.png" alt="shoe">
    </div>
  </main>

<?php require_once 'partials/_script.php' ?>