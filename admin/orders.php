<?php
  require '../core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  if (!has_permission('admin')) {
    permission_error_redirect('index.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  //complete ORDER
  if (isset($_GET['complete']) && $_GET['complete'] == 1) {
    $cart_id = sanitize((int)$_GET['cart_id']);
    $db->query("UPDATE cart SET shipped = 1 WHERE id = '{$cart_id}'");
    $_SESSION['success_flash'] = "The order has been Completed";
    header('Location: index.php');
  }

  //Deny Tranxac
  if (isset($_GET['deny']) && $_GET['deny'] == 1) {
    $cart_id = sanitize((int)$_GET['cart_id']);
    $db->query("UPDATE cart SET denied = 1 WHERE id = '{$cart_id}'");
    $_SESSION['success_flash'] = "The order has been Denied";
    header('Location: index.php');
  }



  $txn_id = sanitize((int)$_GET['txn_id']);
  $txnQ = $db->query("SELECT * FROM transactions WHERE id = '{$txn_id}'");
  $txn = mysqli_fetch_assoc($txnQ);
  $cart_id = $txn['cart_id'];
  $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $cart = mysqli_fetch_assoc($cartQ);
  $items = json_decode($cart['items'],true);
  $idArray = array();
  $products = array();
  foreach ($items as $item) {
    $idArray[] = $item['id'];
  }
  $ids = implode(',',$idArray);
  $productQ = $db->query("SELECT i.id as 'id', i.title as 'title', c.id as 'cid', c.category as 'child',
              p.category as 'parent'
              FROM products i
              LEFT JOIN categories c ON i.categories = c.id
              LEFT JOIN categories p ON c.parent = p.id
              WHERE i.id IN ({$ids})
                ");
  while ($p = mysqli_fetch_assoc($productQ)) {
    foreach ($items as $item) {
      if ($item['id'] == $p['id']) {
        $x = $item;
        continue;
      }
    }
    $products[] = array_merge($x,$p);
  }
 ?>
 <h1 class="text-center" style="font-family: 'Trirong', serif;">Items Ordered</h1><br><hr>
 <div style="font-family: 'Slabo 27px', serif;" class="container col-md-12">
 <table  class="table table-striped table-condensed table-bordered">
   <thead>
     <th>Quantity</th><th>Title</th><th>Category</th><th>Format</th>
   </thead>
   <tbody>
     <?php foreach($products as $product): ?>
       <tr>
         <td><?=$product['quantity'];?></td>
         <td><?=$product['title'];?></td>
         <td><?=$product['parent'].' ▶ '.$product['child'];?></td>
         <td><?=$product['format'];?></td>
       </tr>
   <?php endforeach; ?>
   </tbody>
 </table>
 <div class="row">
   <div class="col-md-6">
     <h3 class="text-center">Order Details</h3>
     <table class="table table-condensed table-striped table-bordered">
       <tbody>
         <tr>
           <td>Sub Total</td>
           <td><?=money($txn['txn_amount'] - ($txn['txn_amount'] * 0.05));?></td>
         </tr>
         <tr>
           <td>Tax</td>
           <td><?=money($txn['txn_amount'] * 0.05)?></td>
         </tr>
         <tr>
           <td>Grand Total</td>
           <td class="text-danger"><?=money($txn['txn_amount']);?></td>
         </tr>
         <tr>
           <td>Order Time and Date</td>
           <td><?=$txn['txn_date_logged'];?></td>
         </tr>
       </tbody>
     </table>
   </div>
   <div class="col-md-6">
     <h3 class="text-center">Shipping Address</h3>

     <address >
       <?php
       $clientQ = $db->query("SELECT * FROM client_details
                   WHERE cart_id = '$cart_id'");
       $tx = mysqli_fetch_assoc($clientQ);
        ?>
           <?=$tx['first_name'].' '.$tx['last_name'];?><br>
           <?=$tx['phone_number'];?><br>
           <?=$tx['street'];?><br>
           <?=(($tx['street2'] != '')?$tx['street2'].', <br />':'');?>
           <?=$tx['city'].', '.$tx['state'].', '.$tx['zip_code'];?><br>
           <?=$tx['country']?><br>
     </address>
   </div>
 </div>
<div class="pull-right">
  <a href="index.php" class="btn btn-large btn-warning gradient">Cancel</a>
  <a href="orders.php?complete=1&cart_id=<?=$cart_id;?>" class="btn btn-large btn-success gradient">Complete Order</a>
  <a href="deny.php?deny=<?=$cart_id;?>" class="btn btn-large btn-danger gradient">Deny Order</a>
</div>
  </div>
<?php include 'includes/footer.php'; ?>
