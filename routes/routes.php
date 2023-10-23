<?php

Flight::set('flight.views.path', 'app/');

Flight::route('/', function(){
    Flight::render('Views/index.php');
});

Flight::route('/signin', function(){
    Flight::render('Views/signin.php');
});

Flight::route('/email/verification', function(){
    Flight::render('Views/email-verification.php');
});

Flight::route('/verify/@token', function($token){
    Flight::render('Views/verify.php', array('token' => $token));
});

Flight::route('/verification/@type/@token', function($type, $token){
    Flight::render('Views/token-verify.php', array('type' => $type, 'token' => $token));
});

Flight::route('/shoes/@type?', function($type){
    Flight::render('Views/default/products.php', array('type' => $type));
});

Flight::route('/shoe/details/@id', function($id){
    Flight::render('Views/default/view-product.php', array('id' => $id));
});

Flight::route('/write-review/@id', function($id){
    Flight::render('Views/default/write-review.php', array('id' => $id));
});

Flight::route('/my-orders/@type?', function($type){
    Flight::render('Views/default/my-orders.php', array('type' => $type));
});

Flight::route('/wishlist', function(){
    Flight::render('Views/default/wish-list.php');
});

Flight::route('/cart', function(){
    Flight::render('Views/default/shopping-cart.php');
});

Flight::route('/dashboard', function(){
    Flight::render('Views/admin/dashboard.php');
});

Flight::route('/categories', function(){
    Flight::render('Views/admin/categories.php');
});

Flight::route('/admin/shoes/@type?', function($type){
    Flight::render('Views/admin/admin-product.php', array('type' => $type));
});

Flight::route('/shoe/add', function(){
    Flight::render('Views/admin/add-product.php');
});

Flight::route('/shoe/update/@id', function($id){
    Flight::render('Views/admin/update-product.php', array('id' => $id));
});

Flight::route('/orders/@type?', function($type){
    Flight::render('Views/admin/orders.php', array('type' => $type));
});

Flight::route('/order/details/@id', function($id){
    Flight::render('Views/admin/order-details.php', array('id' => $id));
});

Flight::route('/customers/@type?', function($type){
    Flight::render('Views/admin/customers.php', array('type' => $type));
});

Flight::route('/reports/@type?', function($type){
    Flight::render('Views/admin/reports.php', array('type' => $type));
});

Flight::route('/settings', function(){
    Flight::render('Views/admin/settings.php');
});

Flight::route('/signout', function(){
    Flight::render('Views/signout.php');
});