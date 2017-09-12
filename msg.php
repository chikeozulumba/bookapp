<?php
require_once 'core/init.php';
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$mCaption = $_POST['caption'];
$phone = $_POST['number'];


if ($name && $email && $message && $phone != '') {
  $insert = $db->query("INSERT INTO messages (caption,full_name,email,phone,messages) VALUES ('$mCaption','$name','$email','$phone','$message')");
  header('Location: index.php');
}else {
  header('Location: index.php');
}





 ?>
