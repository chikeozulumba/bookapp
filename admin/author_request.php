<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
if (!has_permission('admin')) {
  permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

$sql = "SELECT * FROM author_registered ORDER BY tx_date";
$result = $db->query($sql);
 ?>
 <div style="font-family: 'Lora', serif;">

<h1 class="text-center page-header">Author Registeration</h1><br>

<table class="table table-bordered table-condensed table-stripped table-hover">
      <thead class="bg-info">
        <th>ID No.</th><th>Full Name</th><th>Author Name</th><th>Email</th><th>Phone Number</th><th>Bio-data</th><th>Amount Paid</th><th>Transaction Ref.</th><th>Transaction Date</th><th>Approval</th>
      </thead>
      <?php while($a = mysqli_fetch_assoc($result)):?>
      <tbody>
        <td><?=$a['id']?>.</td>
        <td><?=$a['title'].' '.$a['first_name'].' '.$a['last_name'];?></td>
        <td><?=$a['author_name'];?></td>
        <td><?=$a['email'];?></td>
        <td><?=$a['phone_number'];?></td>
        <td><a onclick="authormodal(<?=$a['id'];?>)" class="btn btn-xs btn-info gradient">Data</a></td>
        <td><?=money($a['bundle'])?></td>
        <td><?=$a['tx_ref']?></td>
        <td><?=$a['tx_date']?></td>
        <td><?=(($a['approved'] == 0 || $a['approved'] == '')?' Pending':'Added');?></td>
      </tbody>
    <?php endwhile; ?>
</table>

</div>
 <?php  include 'includes/footer.php'; ?>
