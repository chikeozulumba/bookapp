<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';


if (isset($_GET['read'])) {
  $id = sanitize($_GET['read']);
  $db->query("UPDATE messages SET read_log = 1 WHERE id = '$id'");
  header('Location: converse.php');
}
 ?>
