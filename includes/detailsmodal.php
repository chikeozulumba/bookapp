<?php
  require_once '../core/init.php';
  $id = $_POST['id'];
  $id = (int)$id;

  $sql = "SELECT * FROM products WHERE id = '$id'";
  $result = $db->query($sql);
  $product = mysqli_fetch_assoc($result);
  $author_id = $product['author'];
  $sql = "SELECT author FROM author WHERE id ='$author_id'";
  $author_query = $db->query($sql);
  $author = mysqli_fetch_assoc($author_query);
  $formatstring = $product['format'];
  $formatstring = rtrim($formatstring,',');
  $format_array = explode(',',$formatstring);
 ?>

<?php ob_start(); ?>
<!--Details Modal-->

<div data-backdrop="static" data-keyboard="false" class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog"
  aria-labelledby="details-1" aria-hidden="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" type="button" onclick="closemodal()"aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 style="font-family: 'Neuton', serif;" class="modal-title text-center"><strong><?php echo $product['title']; ?></strong></h3>

      </div>
      <div class="modal-body" id="1mod">
        <div class="container-fluid">
          <div class="row">
            <span style="font-family: 'Rakkas', cursive;" id="modal_errors" class="bg-danger"></span>
            <div class="col-sm-6 fotorama">
              <?php $photos = explode(',',$product['image']);
              foreach ($photos as $photo):?>
                <div class="center-block">
                  <img src="<?=$photo;?>" alt="<?php echo $product['title']; ?>"
                  class="details img-responsive" id="productPhoto" style="width: 70%; margin: 25px auto;"/>
                </div>
            <?php endforeach; ?>
            </div>
            <div class="col-sm-6">
              <h4 style="font-family: 'Eczar', serif;" class="text-center"><strong>Details</strong></h4>
              <h4 style="font-family: 'Cormorant Upright', serif;"><strong><?php echo nl2br($product['description']); ?></strong></h4>
              <hr />
              <p style="font-family: 'Rakkas', cursive;">Price: <strong class="text-danger"> ₦ <?php echo $product['price']; ?></strong> </p>
              <p style="font-family: 'Rakkas', cursive;">Author: <?php echo $author['author']; ?></p>
              <form action="add_cart.php" method="post" id="add_product_form">
                <input type="hidden" name="product_id" value="<?=$id;?>">
                <input type="hidden" name="available" id="available" value="">
                  <div class="form-group">
                    <br>
                      <div class="col-xs-3">
                        <label for="quantity" style="font-family: 'Rakkas', cursive;">Quantity:</label>
                        <input type="number" class="form-control" id="quantity"
                        name="quantity" placeholder="Add" min="0"/>
                      </div><div class="col-xs-9"></div>
                  </div><br><br><br>
                  <div class="form-group">
                    <label for="format" style="font-family: 'Rakkas', cursive;">Format:</label>
                    <select style="font-family: 'Trirong', serif;" class="form-control" id="format" name="format">
                      <option style="font-family: 'Trirong', serif;" value=""></option>
                      <?php foreach ($format_array as $string) {
                        $string_array = explode(':',$string);
                        $format = $string_array[0];
                        $available = $string_array[1];
                        if ($available > 0) {
                        echo '<option value="'.$format.'" data-available="'.$available.'">'.$format.'('.$available.' Available)</option>';
                            };
                      }?>
                    </select>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default btn-sm" onclick="closemodal()">Close</button>
        <button class="btn btn-warning btn-sm" onclick="add_to_cart();return false;">
          <span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo ob_get_clean(); ?>
<script>
  jQuery('#format').change(function(){
    var available = jQuery('#format option:selected').data('available');
    jQuery('#available').val(available);
  });

  //$(function () {
  //  $('.fotorama').fotorama({'loop':true,'autoplay':true});
//  });


  function closemodal(){
    jQuery('#details-modal').modal('hide');
    setTimeout(function(){
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
    },500);
  };
</script>
<style media="screen">
  #productPhoto img{
    width: 70%;
    margin: 25px auto;
  }
</style>
