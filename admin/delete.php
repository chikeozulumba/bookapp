<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';


if (isset($_GET['remove'])) {
  $id = sanitize($_GET['remove']);
  $db->query("UPDATE messages SET deleted = 1 WHERE id = '$id'");
  header('Location: converse.php');
}
 ?>
