<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$wishlistId = Utilities::sanitize($_POST['wishlist_id']);

echo $wishlistController->delete($wishlistId);