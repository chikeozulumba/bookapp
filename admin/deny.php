<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';


  if (isset($_GET['deny'])) {
    $id = sanitize($_GET['deny']);
    $db->query("UPDATE cart SET denied = 1 WHERE id = '$id'");
    $db->query("UPDATE cart SET paid = 0 WHERE id = '$id'");
    #$db->query("UPDATE products SET deleted = 0 WHERE id = '$id'");
    header('Location: approved.php');
}

 ?>
