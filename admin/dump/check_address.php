<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/headerpartial.php';
  include 'includes/navigation.php';

  if ($cart_id != '') {
    $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $result = mysqli_fetch_assoc($cartQ);
    $items = json_decode($result['items'],true);
    $i = 1;
    $sub_total = 0;
    $item_count = 0;
  }


?>

<div class="col-md-12">
  <div class="row">
    <h2 style="font-family: 'Trirong', serif;" class="text-center">My Shopping Cart</h2><hr>
    <?php if ($cart_id == ''):?>
      <div class="bg-danger">
        <p class="text-center text-danger">Your shopping cart is empty!<a href="index.php"> Back to Home Page</a></p>
      </div>
    <?php else: ?>
      <table class="table table-bordered table-condensed table-striped">
        <thead style="font-family: 'Slabo 27px', serif;"><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Book Format</th><th>Sub-Total</th></thead>
        <tbody>
          <?php
            foreach ($items as $item) {
              $product_id = $item['id'];
              $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
              $product = mysqli_fetch_assoc($productQ);
              $fArray = explode(',',$product['format']);
              foreach ($fArray as $formatString) {
                $f = explode(':',$formatString);
                if ($f[0] == $item['format']) {
                  $available = $f[1];
                }
              }
              ?>
                <tr>
                  <td style="font-family: 'Rakkas', cursive;"><?=$i;?></td>
                  <td style="font-family: 'Rakkas', cursive;"><?=$product['title'];?></td>
                  <td style="font-family: 'Rakkas', cursive;"><?=money($product['price']);?></td>
                  <td>
                    <button type="button" class="btn btn-xs btn-warning" onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['format'];?>');">-</button>
                    <?=$item['quantity'];?>
                    <?php if($item['quantity'] < $available):?>
                      <button type="button" class="btn btn-xs btn-success" onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['format'];?>');">+</button>
                    <?php else: ?>
                      <span class="text-danger">Max!</span>
                    <?php endif; ?>
                  </td>
                  <td style="font-family: 'Rakkas', cursive;"><?=$item['format'];?></td>
                  <td style="font-family: 'Rakkas', cursive;"><?=money($item['quantity'] * $product['price']);?></td>
                </tr>
            <?php
              $i++;
              $item_count += $item['quantity'];
              $sub_total += ($product['price'] * $item['quantity']);
            }
          #  $tax = TAXRATE * $sub_total;
          #  $tax = number_format($tax,3);
            $grand_total = $sub_total;

             ?>
        </tbody>
      </table>

      <h2 class="text-center" style="font-family: 'Trirong', serif;">Payment Info:</h2>
      <table class="table table-bordered table-condensed text-right">
        <thead style="font-family: 'Slabo 27px', serif;" class="totals-table-header"><th>Total Items</th><th>Sub-Total</th><!--<th>Tax</th>--><th>Grand Total (V.A.T. inclusive)</th></thead>
        <tbody style="font-family: 'Rakkas', cursive;">
          <tr>
            <td><?=$item_count;?></td>
            <td><?=money($sub_total);?></td>
            <!--<td><?=money($tax);?></td>-->
            <td class="bg-success" value readonly><?=money($grand_total + ($grand_total * 0.05));?></td>
          </tr>
        </tbody>
      </table>
      <H3 class="text-center" style="font-family: 'Slabo 27px', serif;">* VAT included for all purchases</H3>

      <!--Checkout Button-->
      <button style="font-family: 'Rakkas', cursive;" type="button" class="btn btn-primary btn-md pull-right gradient" data-toggle ="modal" data-target="#checkoutModal">
        <span class="glyphicon glyphicon-shopping-cart"></span> Check Out >>
      </button>

      <!--Modal-->
      <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 style="font-family: 'Trirong', serif;" class="modal-title text-center" id="checkoutModalLabel">Shipping Address</h4>
            </div>
              <div class="modal-body">
                <div class="row">
                <form id="payment-form" action="create_payment.php" method="post">
                  <span class="bg-danger" id="payment-errors"></span>
                  <div id="step1" style="display:block">
                    <div class="form-group col-md-6" style="font-family: 'Slabo 27px', serif;">
                      <label for="full_name">Full Name:</label>
                      <input class="form-control" id="full_name" name="full_name" type="text" value="">
                    </div>

                    <div class="form-group col-md-6" style="font-family: 'Slabo 27px', serif;">
                      <label for="email">Email:</label>
                      <input class="form-control" id="email" name="email" type="email" value="">
                    </div>

                    <div class="form-group col-md-6" style="font-family: 'Slabo 27px', serif;">
                      <label for="phone_number">Phone Number:</label>
                      <input class="form-control" id="phone_number" name="phone_number" type="phone_number" value="">
                    </div>

                    <div class="form-group col-md-6" style="font-family: 'Slabo 27px', serif;">
                      <label for="street">Street Adress:</label>
                      <input class="form-control" id="street" name="street" type="text" value="">
                    </div>

                    <div class="form-group col-md-6" style="font-family: 'Slabo 27px', serif;">
                      <label for="street2">Street Address 2:</label>
                      <input class="form-control" id="street2" name="street2" type="text" value="">
                    </div>

                    <div class="form-group col-md-6" style="font-family: 'Slabo 27px', serif;">
                      <label for="city">City:</label>
                      <input class="form-control" id="city" name="city" type="text" value="">
                    </div>

                    <div class="form-group col-md-6" style="font-family: 'Slabo 27px', serif;">
                      <label for="state">State:</label>
                      <input class="form-control" id="state" name="state" type="text" value="">
                    </div>

                    <div class="form-group col-md-6" style="font-family: 'Slabo 27px', serif;">
                      <label for="zip_code">Zip Code:</label>
                      <input class="form-control" id="zip_code" name="zip_code" type="text" value="">
                    </div>

                    <div class="form-group col-md-6" style="font-family: 'Slabo 27px', serif;">
                      <label for="country">Country:</label>
                      <input class="form-control" id="country" name="country" type="text" value="">
                    </div>

                  </div>

                  <!--step 2-->

                  <!--<div id="step2" style="display:none; font-family: 'Slabo 27px', serif;">
                    <div class="form-group col-md-3">
                      <label for="name">Name on Card:</label>
                      <input type="text" id="name" class="form-control">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="number">Card Number:</label>
                      <input type="text" id="cvc" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="cvc">CVC Number:</label>
                      <input type="text" id="number" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="expire-year">Expire Month:</label>
                      <select class="form-control" id="expire-month">
                        <option value=""></option>
                        <?php for($i=1;$i < 13; $i++): ?>
                          <option value="<?=$i;?>"><?=$i;?></option>
                        <?php endfor; ?>
                      </select>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="expire-year">Expire Year:</label>
                      <select class="form-control" id="expire-year">
                        <option value=""></option>
                        <?php $year = date("Y"); ?>
                        <?php for($i=0;$i<11;$i++): ?>
                          <option value="<?=$year+$i;?>"><?=$year+$i;?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                  </div>-->

              </div>
              </div>
            <div class="modal-footer">
              <button style="font-family: 'Rakkas', cursive;" type="button" class="btn btn-default btn-md outline" data-dismiss="modal">Close</button>
              <button style="font-family: 'Rakkas', cursive;" type="button" class="btn btn-primary btn-md outline" onclick="check_address();" id="next_button">Next >></button>
              <button style="font-family: 'Rakkas', cursive;" type="button" class="btn btn-primary btn-md outline" onclick="back_address();" id="back_button" style="display:none;"><< Back</button>
              <button style="font-family: 'Rakkas', cursive;" type="submit" class="btn btn-primary btn-md outline" id="check_out_button" style="display:none;" >Check Out >></button>
            </form>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<script type="text/javascript">
  function back_address(){
    jQuery('#payment-errors').html("");
    jQuery('#step1').css("display","block");
    jQuery('#step2').css("display","none");
    jQuery('#next_button').css("display","inline-block");
    jQuery('#back_button').css("display","none");
    jQuery('#check_out_button').css("display","none");
    jQuery('#checkoutModalLabel').html("Shipping Address");
  };
  function check_address(){
    var data = {
      'full_name' : jQuery('#full_name').val(),
      'email' : jQuery('#email').val(),
      'phone_number' : jQuery('#phone_number').val(),
      'street' : jQuery('#street').val(),
      'street2' : jQuery('#street2').val(),
      'city' : jQuery('#city').val(),
      'state' : jQuery('#state').val(),
      'zip_code' : jQuery('#zip_code').val(),
      'country' : jQuery('#country').val(),
    };
    jQuery.ajax({
      url : '/CEPA/admin/parsers/check_address.php',
      method : 'POST',
      data : data,
      success : function(data){
        if (data != 'passed') {
          jQuery('#payment-errors').html(data);
        }
        if (data == 'passed') {
          jQuery('#payment-errors').html("");
          jQuery('#step1').css("display","none");
          jQuery('#step2').css("display","block");
          jQuery('#next_button').css("display","none");
          jQuery('#back_button').css("display","inline-block");
          jQuery('#check_out_button').css("display","inline-block");
          jQuery('#checkoutModalLabel').html("Enter Your Card Details");
        }
      },
      error : function(){alert("something wrong");},
    })
  }
</script>



<?php include 'includes/footer.php';?>
<style media="screen">
#check_out_button{
  display: none;
}
#back_button{
  display: none;
}
#partialheaderWrapper{
  position: relative;
  padding: 0;
  margin: 0;
  overflow: hidden;
  height: 180px;
  background-image: url(img/headerlogo/bkd3.jpg);
  background-repeat: no-repeat;
  background-size: 100% 500px;
  background-position: top center;
  background-attachment: fixed;
}

#partiallogotext{
  position: absolute;
  width: 100%;
  height: 260px;
  background-image: url(img/headerlogo/2text.png);
  background-repeat: no-repeat;
  background-position: center;
  background-size: 70% 500px;
  top: 50%;
  margin-top: -90px;
}
.totals-table-header th{
  text-align: center;
}
</style>
