<?php
  function display_errors($errors){
    $display = '<div class="bg-danger text-danger"></div>';
    foreach ($errors as $error) {
      $display .='<li class="text-danger" style="font-family: Trirong, serif;">'.$error.'</li>';
    }
    $display .='</ul>';
    return $display;
  }

  function sanitize($dirty){
    return htmlentities($dirty,ENT_QUOTES,"UTF-8");
  }

  function money($number){
    return '₦'.number_format($number,2);
  }

  function login($user_id){
    $_SESSION['CEPAUser'] = $user_id;
    global $db;
    $date = date("Y-m-d H:i:s");
    $db->query("UPDATE users SET last_login = '$date' WHERE id ='$user_id'");
    $_SESSION['success_flash'] = 'You are now logged in!';
    header('Location: index.php');
  }

  function is_logged_in(){
    if (isset($_SESSION['CEPAUser']) && $_SESSION['CEPAUser'] > 0) {
      return true;
    }
    return false;
  }
  function login_error_redirect($url = 'login.php'){
  $_SESSION['error_flash'] = 'You must be logged in to access the Admin page';
  header('Location: '.$url);
}

  function permission_error_redirect($url = 'login.php'){
  $_SESSION['error_flash'] = 'You do not have permission to access the Admin page';
  header('Location: '.$url);
}

function editor_error_redirect($url = 'login.php'){
$_SESSION['error_flash'] = 'You do not have permission to access this page';
header('Location: '.$url);
}
  function has_permission($permission = 'admin'){
    global $user_data;
    $permissions = explode(',', $user_data['permissions']);
    if (in_array($permission,$permissions,true)) {
      return true;
    }
    return false;
  }
  function get_category($child_id){
  global $db;
  $id = sanitize($child_id);
  $sql = "SELECT p.id AS 'pid', p.category AS 'parent', c.id AS 'cid', c.category AS 'child'
          FROM categories c
          INNER JOIN categories p
          ON c.parent = p.id
          WHERE c.id = '$id'";
  $query = $db->query($sql);
  $category = mysqli_fetch_assoc($query);
  return $category;
}
function pretty_date($date){
  return date("M d, Y h:i A",strtotime($date));
}

function formatToArray($string){
  $formatArray = explode(',',$string);
  $returnArray =array();
  foreach ($formatArray as $format) {
    $s = explode(':',$format);
    $returnArray[] = array('format' => $s[0], 'quantity' => $s[1]);
  }
  return $returnArray;
}

function formatToString($format){
  $formatString = '';
  foreach ($format as $FormatU) {
    $formatString .= $FormatU['format'].':'.$FormatU['quantity'].',';
  }
  $trimmed = rtrim($formatString, ',');
  return $trimmed;
}
 ?>
