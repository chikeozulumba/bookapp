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

// $getMsg = $db->query("SELECT f.id, f.full_name, f.phone_number, f.email, f.message, f.date_log
//   FROM feedback f ");
// $msg = mysqli_fetch_assoc($getMsg);
 ?>
 <h1 class="page-header text-center" style="font-family: 'Trirong', serif;">Messages</h1>

 <table  class="table table-hover table-danger table-condensed table-stripped table-bordered">
   <thead style="font-family: 'Trirong', serif;" class="thead-inverse">
     <th>Msg No.</th>
     <th>Date & Time</th>
     <th>Name</th>
     <th>Phone Number</th>
     <th>Email</th>
     <th>Caption</th>
     <th>View</th>
     <th>Delete</th>
   </thead>
<?php
  $mQ = $db->query("SELECT * FROM messages WHERE read_log = 0 AND deleted = 0");
  while($msg = mysqli_fetch_assoc($mQ)):
  ?>
   <tbody style="font-family: 'Slabo 27px', serif;">
     <td><?=$msg['id'];?></td>
     <td><?=$msg['date_log'];?></td>
     <td><?=$msg['full_name'];?></td>
     <td><?=$msg['phone'];?></td>
     <td><?=$msg['email'];?></td>
     <td><?=$msg['caption'];?></td>
     <td><a class="btn btn-xs btn-success gradient" onclick="msgmodal(<?=$msg['id'];?>)">view</a></td>
     <td><a class="btn btn-xs btn-danger gradient" href="delete.php?remove=<?=$msg['id'];?>">delete</a></td>
   </tbody>
 <?php endwhile; ?>

 </table>
<?php include 'includes/footer.php'; ?>
