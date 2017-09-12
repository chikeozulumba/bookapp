<?php
  require_once 'core/init.php';
  //Load composer autoload
  require_once __DIR__ . '/vendor/autoload.php';
  //load environment variables
  (new \Dotenv\Dotenv(__DIR__))->load();

  $paystack = new \Yabacon\Paystack(PAYSTACK_SECRET_KEY);

  $full_name = sanitize($_POST['full_name']);
  $email = sanitize($_POST['email']);
  $phone_number = sanitize($_POST['phone_number']);
  $street = sanitize($_POST['street']);
  $street2 = sanitize($_POST['street2']);
  $city = sanitize($_POST['city']);
  $state = sanitize($_POST['state']);
  $zip_code = sanitize($_POST['zip_code']);
  $country = sanitize($_POST['country']);
  $sub_total = sanitize($_POST['sub_total']);
  $grand_total = sanitize($_POST['grand_total']);
  $cart_id = sanitize($_POST['cart_id']);
  $description = sanitize($_POST['description']);
  $charge_amount = number_format($grand_total,2) * 100;



  //get customer email
  $customer_email = $email;


    // get a code to use for this transaction
    $newcode = getUnusedCode();
    // save the array to a file named by the code chosen
    file_put_contents('results/' . $newcode . '-request.json', json_encode($req));


    // initiate transaction (Remember to change this if you are using Guzzle)
      $virdir = new VirtualDirectory();

      // Check the README here > https://github.com/yabacon/paystack-php/
      $response = $paystack->transaction->initialize([
                      'reference'=>$newcode,
                      'amount'=>$charge_amount, // in kobo
                      'email'=>$email,
                      'callback_url'=>rtrim($virdir->thisURL,'/') . '/payment_conclude.php'
                    ]);
      // check if transaction url was generated
      $url = $response->data->authorization_url; // more about data on: https://developers.paystack.co/docs/paystack-standard
      // redirect to receive payment
      header('Location: '.$url);
      die();


 ?>
