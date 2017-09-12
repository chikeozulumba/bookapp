<?php
require_once '../core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
if (!has_permission('admin')) {
  permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

if (isset($_GET['add'])) {
  $email = $_POST['email'];
  if ($email != '') {
    $insert = $db->query("INSERT INTO subscription (email) VALUES ('$email')");
    header('Location: ../index.php');
  }else {
    header('Location: ../index.php');
    }
}

$subQ = $db->query("SELECT * FROM subscription ORDER BY date_log DESC");

 ?>
 <div style="font-family: 'Trirong', serif;">
<h1 class="page-header text-center">Subscription</h1>
<div class="container">
<div class="row">
<div class="container-fluid">
<div class="col-md-9">
<table class="table table-stripped table-condensed table-bordered">
  <thead>
    <th>No.</th>
    <th>Email</th>
    <th>Date subscribed</th>
  </thead>
  <?php while($sub = mysqli_fetch_assoc($subQ)): ?>
  <tbody>
    <td><?=$sub['id'];?></td>
    <td><?=$sub['email'];?></td>
    <td><?=date($sub['date_log']);?></td>
  </tbody>
<?php endwhile; ?>
</table>

</div>
</div>
</div>
</div>

</div>
<?php include 'includes/footer.php'; ?>
