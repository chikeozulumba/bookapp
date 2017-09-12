<?php
  require_once '../core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  if (!has_permission('admin')) {
    editor_error_redirect('index.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
 ?>
 <?php
 $ShippedQuery = "SELECT c.id, t.cart_id, a.phone_number, t.customer_email, t.txn_amount, t.txn_ref, t.txn_date_logged, c.items, c.paid, c.shipped, a.description, a.first_name, a.last_name
     FROM transactions t
     LEFT JOIN cart c ON t.cart_id = c.id
     LEFT JOIN client_details a ON a.cart_id = c.id
     WHERE c.paid = 1 AND c.shipped = 1
     ORDER BY t.txn_date_logged";
 $ShippedR = $db->query($ShippedQuery);



  ?>
<h1 style="font-family: 'Trirong', serif;" class="text-center">Shipped</h1><hr>
<div class="col-md-6">
  <h3 style="font-family: 'Trirong', serif;" class="text-center">Approved Transactions</h3>
  <table style="font-family: 'Slabo 27px', serif;" class="table table-stripped table-bordered table-condensed ">
    <thead>
      <th></th>
      <th>Name</th>
      <th>Transaction Ref.</th>
      <th>Contact No.</th>
      <th>Status</th>
    </thead>
    <tbody>
      <?php while($sh = mysqli_fetch_assoc($ShippedR)):
        $cart_id = sanitize((int)$sh['id']);
         ?>
      <tr>
        <td><a href="rollback.php?rollback=<?=$cart_id;?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-refresh"></a>
        <a href="deny.php?deny=<?=$cart_id;?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
          <td><?=$sh['first_name'].' '.$sh['last_name'];?></td>
          <td><?=$sh['txn_ref'];?></td>
          <td><?=$sh['phone_number'];?></td>
          <td><?=(($sh['shipped'] == 1)?' Approved':'');?></td>
      <?php endwhile; ?>
      </tr>
    </tbody>
  </table>
</div>

<?php #Denied Transactions
$Deny = $db->query("SELECT c.id, c.denied, t.cart_id, a.phone_number, t.customer_email, t.txn_amount, t.txn_ref, t.txn_date_logged, c.items, c.paid, c.shipped, a.description, a.first_name, a.last_name
    FROM transactions t
    LEFT JOIN cart c ON t.cart_id = c.id
    LEFT JOIN client_details a ON a.cart_id = c.id
    WHERE c.denied = 1
    ORDER BY t.txn_date_logged");


?>
<div class="col-md-6">
<h3 style="font-family: 'Trirong', serif;" class="text-center">Disallowed</h3>
<table style="font-family: 'Slabo 27px', serif;" class="table table-stripped table-bordered table-condensed ">
  <thead>
    <th></th>
    <th>Name</th>
    <th>Transaction Ref.</th>
    <th>Contact No.</th>
    <th>Status</th>
  </thead>
  <tbody>
    <?php while($Den = mysqli_fetch_assoc($Deny)):
      $cart_id = sanitize((int)$Den['id']);
       ?>
    <tr>
      <td><a href="rollback.php?rollback=<?=$cart_id;?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-refresh"></a>
        <td><?=$Den['first_name'].' '.$Den['last_name'];?></td>
        <td><?=$Den['txn_ref'];?></td>
        <td><?=$Den['phone_number'];?></td>
        <td><?=(($Den['denied'] == 1)?' Denied':'');?></td>
    <?php endwhile; ?>
    </tr>
  </tbody>
</table>
</div>
<?php include 'includes/footer.php'; ?>
