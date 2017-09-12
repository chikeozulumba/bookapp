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


    //update author_reg
    $db->query("INSERT INTO author_paid
      (author_email,txn_amount,txn_ref,txn_date,auth_code,confirmation) VALUES
      ('$email','$updated_amt','$dreference','$ddate','$auth_code','$dstatus')");
    #header('Location: thankyou.php');


include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
include 'includes/contactmodal.php';

?>

<?php
$txnQuery = $db->query("SELECT * FROM author_registered WHERE tx_ref = '7AAAAAAAAAF' AND email = 'chike.ozulumba@gmail.com'");
$rst = mysqli_fetch_assoc($txnQuery);


 ?>
<h2 class="text-center" style="font-family: 'Trirong', serif;">Thank You for registering.</h2>

<div class="col-md-3"></div>

<div class="col-md-6 text-center" style="font-family: 'Neuton', serif;">
  <h4>
    Hello, <?= $rst['title'].' '.$rst['first_name'].' '.$rst['last_name']; ?> you have successfully been registered on CEPA-Bookshop.<br>
    All details on proceedings will be sent to your email address, <strong class="text-primary"><?= $rst['email'] ?></strong> .
  </h4>
  <h4>
    Your debit card has been debited the sum of ₦ <?=$updated_amt;?>.
    An email, containing your reciept and transaction details for your registeration has been forwarded to your inbox.
  </h4>
  <h4>
    Your transaction reference code is <strong class="text-danger"><?=$dreference;?></strong>
  </h4>

  <h4 class="text-success">
    Your registeration will be processed within 24 hours.<br>
    Additional details will be sent to your email address.<br>
  </h4>

  <h5>**** Please, You can also print out this page as a reciept.****</h5>
  <h5>For more info, you can <a href="#contact" data-toggle="modal">Contact</a> or call our help-line +2348131976306. </h5>

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
