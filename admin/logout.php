<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';
unset($_SESSION['CEPAUser']);
header('Location: login.php');


 ?>
