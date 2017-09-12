<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';


  if (isset($_GET['rollback'])) {
    $id = sanitize($_GET['rollback']);
    $db->query("UPDATE cart SET shipped = 0 WHERE id = '$id'");
    $db->query("UPDATE cart SET denied = 0 WHERE id = '$id'");
    $db->query("UPDATE cart SET paid = 1 WHERE id = '$id'");
    #$db->query("UPDATE products SET deleted = 0 WHERE id = '$id'");
    header('Location: index.php');
}



 ?>
