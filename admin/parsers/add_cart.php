<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';
  $product_id = sanitize($_POST['product_id']);
  $format       = sanitize($_POST['format']);
  $quantity   = sanitize($_POST['quantity']);
  $available  = sanitize($_POST['available']);
  $item = array();
  $item[] = array(
    'id' => $product_id,
    'format' => $format,
    'quantity' => $quantity,
  );

  $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?false:false;
  $query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
  $product = mysqli_fetch_assoc($query);
  $_SESSION['success_flash'] = $product['title'].' has been added to your cart';

  // check if the cart_cookie exists
  if($cart_id != ''){
    $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $cart = mysqli_fetch_assoc($cartQ);
    $previous_items = json_decode($cart['items'],true);
    $item_match = 0;
    $new_items = array();
    foreach ($previous_items as $pitem) {
      if($item[0]['id'] == $pitem['id'] && $item[0]['format'] == $pitem['format']){
        $pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
        if($pitem['quantity'] > $available){
          $pitem['available'] = $available;
        }
        $item_match  = 1;
      }
      $new_items[] = $pitem;
    }
    if($item_match != 1){
      $new_items = array_merge($item,$previous_items);
    }
    $items_json = json_encode($new_items);
    $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
    $db->query("UPDATE cart SET items = '{$items_json}', expire_date = '{$cart_expire}' WHERE id = '{$cart_id}'");
    setcookie(CART_COOKIE,'',1,'/',$domain,false);
    setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
  } else {
    // add the cart to the database and set cookie
    $items_json = json_encode($item);
    $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
    $db->query("INSERT INTO cart (items,expire_date) VALUES ('{$items_json}','{$cart_expire}')");
    // grab the last inserted id to be use as the cart id
    $cart_id = $db->insert_id;
    setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
  }
?>﻿
