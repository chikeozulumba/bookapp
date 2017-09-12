<?php
require_once '../../core/init.php';
$id = $_POST['id'];
$id = (int)$id;

$sql = "SELECT * FROM messages WHERE id = '$id'";
$result = $db->query($sql);
$msg = mysqli_fetch_assoc($result);


?>
<!--Modal  -->
<div data-backdrop="static" data-keyboard="false" style="font-family: 'Trirong', serif;" class="modal fade" id="message" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <h4 style="font-family: 'Slabo 27px', serif;" class="text-center">Message from: <?=$msg['full_name'];?></h4>
            <h5 style="font-family: 'Slabo 27px', serif;" class="text-center"><strong>Date & Time: <?=$msg['date_log'];?></strong></h5>
          </div>
            <div class="modal-body">
              <div class="form-group">
                <div class="" readonly>
                    <?=$msg['messages'];?>
                </div>
            <div class="modal-footer">
              <a class="btn btn-default outline" onclick="closemodal()">back</a>
              <a type="submit" class="btn btn-primary outline" href="read.php?read=<?=$msg['id'];?>">Mark as read</a>
            </div>
        </div>
      </div>
    </div>
    </div>
    </div>

<script>
function closemodal(){
  jQuery('#message').modal('hide');
  setTimeout(function(){
    jQuery('#message').remove();
    jQuery('.modal-backdrop').remove();
  },500);
};
</script>
