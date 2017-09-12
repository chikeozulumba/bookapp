<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';


if (isset($_GET['add'])) {
  $id = sanitize($_GET['add']);
  $aQ = $db->query("SELECT author_name FROM author_registered WHERE id = '$id'");
  $aR = mysqli_fetch_assoc($aQ);
  $author = $aR['author_name'];
  $db->query("UPDATE author_registered SET approved = 1 WHERE id = '$id'");
  $db->query("INSERT INTO author (author) VALUES ('$author')");
  header('Location: author_request.php');
}
 ?>
