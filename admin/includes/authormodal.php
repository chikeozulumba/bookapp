<?php
require_once '../../core/init.php';
$id = $_POST['id'];
$id = (int)$id;

$sql = "SELECT * FROM author_registered WHERE id = '$id'";
$result = $db->query($sql);
$a = mysqli_fetch_assoc($result);


?>
<?php ob_start(); ?>

<!--Modal  -->
<div data-backdrop="static" data-keyboard="false" style="font-family: 'Trirong', serif;" class="modal fade" id="author" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <h4 style="font-family: 'Slabo 27px', serif;" class="text-center">Author's Biodata</h4>
            <h4 style="font-family: 'Slabo 27px', serif;" class="text-center text-primary"><?=$a['title'].' '.$a['first_name'].' '.$a['last_name'];?></h4>
            <h5 style="font-family: 'Slabo 27px', serif;" class="text-center"><strong>Date & Time: <?=$a['tx_date'];?></strong></h5>
          </div>
            <div class="modal-body">
              <div class="form-group">
                <div class="" readonly>
                  <address >
                    Author name selected:         <strong><?=$a['author_name'];?></strong><br>
                    Phone Number:                 <strong><?=$a['phone_number'];?></strong><br>
                    Email address:                 <strong><?=$a['email'];?></strong><br>
                    Highest qualification(Degree): <strong><?=$a['highest_q'];?></strong><br>
                    Institution attended:          <strong><?=$a['institution'];?></strong><br>
                    Current occupation:            <strong><?=$a['occupation'];?></strong><br>
                    Address:                       <strong><?=$a['street'].', '.$a['city'].', '.$a['state'].', '.$a['country'];?></strong><br>
                    Date and Time of registeration: <strong><?=$a['tx_date'];?></strong>
                  </address>
                </div>
            <div class="modal-footer">
              <a class="btn btn-default outline" onclick="closemodal()">back</a>
              <a type="submit" class="btn btn-success outline" href="add_to_authors.php?add=<?=$a['id'];?>">Add to Authors</a>
            </div>
        </div>
      </div>
    </div>
    </div>
    </div>
<?php echo ob_get_clean(); ?>
<script>
function closemodal(){
  jQuery('#author').modal('hide');
  setTimeout(function(){
    jQuery('#author').remove();
    jQuery('.modal-backdrop').remove();
  },500);
};
</script>
