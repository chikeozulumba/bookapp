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
    $req['bundle'] = floatval(filter_input(INPUT_POST, 'bundle'));

    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $author_name = $_POST['author_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $street = $_POST['street'];
    $highQual = $_POST['highest_qualification'];
    $institution = $_POST['institution'];
    $occupation = $_POST['occupation'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $plan = $_POST['bundle'];
    $course = $_POST['course'];
    $charge = $plan * 100;
    // get a code to use for this transaction
    $newcode = getUnusedCode();
    // save the array to a file named by the code chosen
    file_put_contents('results/' . $newcode . '-request.json', json_encode($req));
    // confirm that we got a valid email
    if (!$req['email']) {
        die('An invalid email was sent');
    }
    // confirm that we got a valid amount
    if (!$req['bundle']) {
        die('An invalid amount was sent');
    }
    // initiate transaction (Remember to change this if you are using Guzzle)
      $virdir = new VirtualDirectory();

      // Check the README here > https://github.com/yabacon/paystack-php/
      $response = $paystack->transaction->initialize([
                      'reference'=>$newcode,
                      'amount'=>$charge, // in kobo
                      'email'=>$req['email'],
                      'callback_url'=>rtrim($virdir->thisURL,'/') . '/author_pay.php'
                    ]);
      // check if transaction url was generated
    if ($url = $response->data->authorization_url) {
      $db->query("INSERT INTO author_registered (course,tx_ref,title,first_name,last_name,author_name,email,phone_number,street,highest_q,institution,
                  occupation,state,city,country,bundle)
              VALUES ('$course','$newcode','$title','$first_name','$last_name','$author_name','$email','$phone_number','$street','$highQual','$institution','$occupation','$state','$city','$country','$plan')");
      header('Location: '.$url);
    }else {
      header('Location: error.php');
    }
      die();

 ?>
