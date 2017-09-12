<?php
  require_once '../core/init.php';
  if (!is_logged_in()) {
    header('Location: login.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

 ?>
 <!--Orders fill-->
 <?php
  $txnQuery = "SELECT t.id, t.cart_id, t.confirmation, a.cart_id, t.customer_email, t.txn_amount, t.txn_ref, t.txn_date_logged, c.items, c.paid, c.shipped, a.first_name, a.last_name, a.phone_number, a.description
      FROM transactions t
      LEFT JOIN cart c ON t.cart_id = c.id
      LEFT JOIN client_details a ON t.cart_id = a.cart_id
      WHERE c.paid = 1 AND c.shipped = 0
      ORDER BY t.txn_date_logged";
  $txnResults = $db->query($txnQuery);

  $clientQ = "SELECT t.id, t.cart_id, a.first_name, a.last_name, a.phone_number, a.description
              FROM client_details t
              LEFT JOIN cart c ON t.cart_id = c.id
              WHERE c.paid = 1 AND c.shipped = 0
              ORDER BY T.txn_date";
  $clientR = $db->query($clientQ);
  ?>
<div class="col-md-12">
  <h1 class="text-center" style="font-family: 'Trirong', serif;"><strong>My Dashboard</strong></h1><hr>
  <table style="font-family: 'Slabo 27px', serif;" class="table table-bordered table-condensed table-stripped">
    <h3 class="text-center" style="font-family: 'Trirong', serif;"><strong>Orders to Ship</strong></h3><br>
    <thead>
      <th class="text-center">Details</th><th class="text-center">First Name</th><th class="text-center">Last Name</th><th class="text-center">Phone Number</th><th class="text-center">Product Description</th><th class="text-center">Email Address</th><th class="text-center">Price Total</th><th class="text-center">Transaction Code</th><th class="text-center">Order Time & Date</th>
    </thead>
    <tbody>
      <?php while ($order = mysqli_fetch_assoc($txnResults)): ?>
      <tr>
        <td><a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-xs btn-info">Details</a></td>
          <?php if($order['confirmation'] == 'success'): ?>
          <td><?=$order['first_name'];?></td>
          <td><?=$order['last_name'];?></td>
          <td><?=$order['phone_number'];?></td>
          <td><?=$order['description'];?></td>
          <td><?=$order['customer_email'];?></td>
          <td>₦ <?=$order['txn_amount'];?></td>
          <td><?=$order['txn_ref'];?></td>
          <td><?=$order['txn_date_logged'];?></td>
        <?php endif; ?>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>

<div class="row">
  <!--sales by Month-->
  <?php
    $thisYr = date("Y");
    $lastYr = $thisYr - 1;
    $thisYrQ = $db->query("SELECT txn_amount, txn_date_logged FROM transactions WHERE YEAR(txn_date_logged) = '{$thisYr}'");
    $lastYrQ = $db->query("SELECT txn_amount, txn_date_logged FROM transactions WHERE YEAR(txn_date_logged) = '{$lastYr}'");
    $current = array();
    $last = array();
    $currentTotal = 0;
    $lastTotal = 0;
    while ($x = mysqli_fetch_assoc($thisYrQ)) {
      $month = date("m",strtotime($x['txn_date_logged']));
      $month = (int)$month;
      if (!array_key_exists($month,$current)) {
        $current[(int)$month] = $x['txn_amount'];
      }else {
        $current[(int)$month] += $x['txn_amount'];
      }
      $currentTotal += $x['txn_amount'];
    };
    while ($y = mysqli_fetch_assoc($lastYrQ)) {
      $month = date("m",strtotime($y['txn_date_logged']));
      $month = (int)$month;
      if (!array_key_exists($month,$current)) {
        $last[(int)$month] = $y['txn_amount'];
      }else {
        $last[(int)$month] += $y['txn_amount'];
      }
      $lastTotal += $y['txn_amount'];
    };

   ?>
  <div class="col-md-4">
    <h3 class="text-center" style="font-family: 'Trirong', serif;"><strong>Sales by Month</strong></h3>
    <table style="font-family: 'Slabo 27px', serif;" class="table table-condensed table-striped table-bordered">
      <thead>
        <th></th>
        <th><?=$lastYr;?> (₦)</th>
        <th><?=$thisYr;?> (₦)</th>
      </thead>
      <tbody>
      <?php for($i=1;$i<= 12;$i++):
          $dt = DateTime::createFromFormat('!m',$i);
        ?>
          <tr<?=((date("m") == $i)?' class="info"':'');?>>
            <td><?=$dt->Format("F");?></td>
            <td><?=(array_key_exists($i,$last))?money($last[$i]):money(0);?></td>
            <td><?=(array_key_exists($i,$current))?money($current[$i]):money(0);?></td>
          </tr>
      <?php endfor; ?>
      <tr class="success">
        <td>Total</td>
        <td><?=money($lastTotal);?></td>
        <td><?=money($currentTotal);?></td>
      </tr>
      </tbody>
    </table>
  </div>

  <!--Inventory-->
  <div class="col-md-8">
    <h3 class="text-center"><strong>Low Inventory</strong></h3>

    <table class="table table-striped table-condensed table-bordered">
      <thead>
        <th>Product</th>
        <th>Category</th>
        <th>Format</th>
        <th>Quantity</th>
        <th>Threshold</th>
      </thead>
      <tbody>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tbody>
    </table>
  </div>
</div>


 <?php include 'includes/footer.php';?>
