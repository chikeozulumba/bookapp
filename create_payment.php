<?php
    require_once 'core/init.php';
    error_reporting(-1);
    require './luhn-creator.php';

    //Load composer autoload
    require_once __DIR__ . '/vendor/autoload.php';
    //load environment variables
    (new \Dotenv\Dotenv(__DIR__))->load();

    $paystack = new \Yabacon\Paystack(PAYSTACK_SECRET_KEY);

    $req = [];

    // add the time of the request to the array
    $req['time'] = gmdate("Y-m-d\TH:i:s\Z");
    // add the user's ip to the array
    $req['ip'] = getIp();
    // get the formdata submitted
    $req['form'] = json_encode($_POST);
    // add the user email to the array
    $req['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    // add the amount to the array
    $req['grand_total'] = floatval(filter_input(INPUT_POST, 'grand_total'));

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $tax = $_POST['tax'];
    $street = $_POST['street'];
    $street2 = $_POST['street2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];
    $sub_total = $_POST['sub_total'];
    $grand_total = $_POST['grand_total'];
    $cart_id = $_POST['cart_id'];
    $description = $_POST['description'];
    $grand_total = $_POST['grand_total'];
    $charge = $grand_total * 100;
    // get a code to use for this transaction
    $newcode = getUnusedCode();
    // save the array to a file named by the code chosen
    file_put_contents('results/' . $newcode . '-request.json', json_encode($req));

    // confirm that we got a valid email
    if (!$req['email']) {
        die('An invalid email was sent');
    }
    // confirm that we got a valid amount
    if (!$req['grand_total']) {
        die('An invalid amount was sent');
    }
    // initiate transaction (Remember to change this if you are using Guzzle)
      $virdir = new VirtualDirectory();

      // Check the README here > https://github.com/yabacon/paystack-php/
      $response = $paystack->transaction->initialize([
                      'reference'=>$newcode,
                      'amount'=>$charge, // in kobo
                      'email'=>$req['email'],
                      'callback_url'=>rtrim($virdir->thisURL,'/') . '/payment_conclude.php'
                    ]);
      // check if transaction url was generated
    if ($url = $response->data->authorization_url) {
      $db->query("INSERT INTO client_details (ref,tax,cart_id,first_name,last_name,email,phone_number,street,street2,city,state,zip_code,country,grand_total,description)
              VALUES ('$newcode','$tax','$cart_id','$first_name','$last_name','$email','$phone_number','$street','$street2','$city','$state','$zip_code','$country','$grand_total','$description')");
      header('Location: '.$url);
    }else {
      header('Location: error.php');
    }
      die();

 ?>
