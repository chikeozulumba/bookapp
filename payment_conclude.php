<?php
/* handles the callback from Paystack,
 *   remember to set this URL here > https://dashboard.paystack.co/#/settings/developer
 */
 require_once 'core/init.php';
 //Load composer autoload
 require_once __DIR__ . '/vendor/autoload.php';

$paystack = new \Yabacon\Paystack(PAYSTACK_SECRET_KEY);

$code = filter_input(INPUT_GET, 'trxref');
if (file_exists('results/' . $code . '-request.json')) {
// check already has a response, never requery
    if (!file_exists('results/' . $code . '-response.json')) {
        // verify the transaction
        $rez = $paystack->transaction->verify(['reference'=>$code]);
        // verify the transaction (would throw an exception if unable to proper API response)
        if($response = $paystack->transaction->verify(['reference'=>$code])){

          $data = $response->data; // more about data on: https://developers.paystack.co/docs/verifying-transactions
          // do what you want with data
          file_put_contents('results/' . $code . '-response.json', json_encode($response));
          #echo $data->status; // tell the status to the customer

      }
        }else {
          header('Location: error.php');
        }


}
#$card = $data->authorization->authorization_code->card_type;
$auth_code = $data->authorization->authorization_code;
$email = $data->customer->email;
$damount = $data->amount;
$updated_amt = $damount / 100;
$ddate = $data->transaction_date;
$dreference = $data->reference;
$dstatus = $data->status;

//adjust inventory
$itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$results = mysqli_fetch_assoc($itemQ);
$items = json_decode($results['items'],true);
foreach ($items as $item) {
  $newFormat = array();
  $item_id = $item['id'];
  $productQ = $db->query("SELECT format FROM products WHERE id = '{$item_id}'");
  $product = mysqli_fetch_assoc($productQ);
  $format = formatToArray($product['format']);
  foreach ($format as $FormatU) {
    if ($FormatU['format'] == $item['format']) {
      $q = $FormatU['quantity'] - $item['quantity'];
      $newFormat[] = array('format' => $FormatU['format'], 'quantity' => $q);
    }else {
      $newFormat[] = array('format' => $FormatU['format'], 'quantity' => $FormatU['quantity']);
    }
  }
  $formatString = formatToString($newFormat);
  $db->query("UPDATE products SET format = '{$formatString}' WHERE id ='{$item_id}'");
}


//update cart
$db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
$db->query("INSERT INTO transactions
  (cart_id,customer_email,txn_amount,txn_ref,txn_date,auth_code,confirmation) VALUES
  ('{$cart_id}','$email','$updated_amt','$dreference','$ddate','$auth_code','$dstatus')");
$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?false:false;
setcookie(CART_COOKIE,'',1,"/",$domain,false);
#header('Location: thankyou.php');


include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';

$sql = "SELECT * FROM client_details WHERE cart_id = '$cart_id'";
$user_info = $db->query($sql);
$user = mysqli_fetch_assoc($user_info);
?>


<h2 class="text-center" style="font-family: 'Trirong', serif;">Thank You for purchasing</h2>

<div class="col-md-3"></div>

<div class="col-md-6 text-center" style="font-family: 'Neuton', serif;">
  <h4>
    Your debit card has been debited the sum of ₦ <?=$updated_amt;?>.
    An email, containing your reciept and transaction details for the purchase of <?=$user['description'];?> has been sent to your email <?=$email;?>.
  </h4>
  <h4>
    Your transaction reference code is <strong class="text-danger"><?=$dreference;?></strong>
  </h4>
  <h4 class="text-center"> The products you purchased will be shipped to your address below:
    <strong>
      <address class="">
        <p class="text-primary">Your Name: </p><p class="text-danger"><?=$user['first_name'].' '.$user['last_name']?></p>
        <p class="text-primary">Phone Number: </p><p class="text-danger"><?=$user['phone_number']?></p>
        <p class="text-primary">Email: </p><p class="text-danger"><?=$user['email']?></p>
        <p class="text-primary">Shipping Address: </p><p class="text-danger"><?=$user['street'].', '.$user['city'].', '.$user['state'].', '.$user['zip_code'].', '.$user['country'];?>
        </p>
      </address>
    </strong>
  </h4>
  <h4 class="text-center">
    Shipping of products will incur additional charges
  </h4>
  <h4 class="text-success">
    Happy reading!
  </h4>
  <h5>**** Products will be delivered within maximum of 7 days.***</h5>
  <h5>**** Please, You can also print out this page as a reciept.***</h5>

<<?php include 'includes/footer.php';?>

</div>


<div class="col-md-3"></div>

<script type="text/javascript">

</script>

<style media="screen">
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
</style>
