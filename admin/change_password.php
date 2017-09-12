<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  include 'includes/head.php';
  $hashed = $user_data['password'];
  $old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
  $old_password = trim($old_password);
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $password = trim($password);
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $confirm = trim($confirm);
  $new_hashed = password_hash($password, PASSWORD_DEFAULT);
  $user_id = $user_data['id'];
  $errors = array();
  ?>

  <div id="login-form">
    <div>
      <?php
        if ($_POST) {
          //form Validation
          if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
            $errors[] = 'You must fill out all the fields available!';
          }



          //password is more than 6 characters
          if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 chatacters!';
          }

          //if new passwords matches confirm
          if ($password != $confirm) {
            $errors[] = 'The new password and confirm new password do not match';
          }

          if (!password_verify($old_password, $hashed)) {
            $errors[] = 'Your old password does not match';
          }
          //check for errors
          if (!empty($errors)) {
            echo display_errors($errors);
          }else {
            //change password
            $db->query("UPDATE users SET password = '$new_hashed' WHERE id ='$user_id'");
            $_SESSION['success_flash'] = 'Your password has been updated!';
            header('Location: index.php');
          }
        }
       ?>

    </div>
    <h2 class="text-center" style="font-family: 'Trirong', serif;">Change Password</h2>
    <form action="change_password.php" method="post">
      <div class="form-group">
        <label for="old_password" style="font-family: 'Trirong', serif;">Password In-Use:</label>
        <input type="password" name="old_password" class="form-control" id="old_password" value="<?=$old_password;?>">
      </div>
      <div class="form-group">
        <label for="password" style="font-family: 'Trirong', serif;">Password:</label>
        <input type="password" name="password" class="form-control" id="password" value="<?=$password;?>">
      </div>
      <div class="form-group" style="font-family: 'Trirong', serif;">
        <label for="confirm">Confirm New Password:</label>
        <input type="password" name="confirm" class="form-control outline" id="confirm" value="<?=$confirm;?>">
      </div>
      <div class="form-group" style="font-family: 'Trirong', serif;">
        <a href="index.php" class="btn btn-warning outline">Cancel</a>
        <input type="submit" class="btn btn-success outline" value="Change password">
      </div>

      <a style="font-family: 'Trirong', serif;" class="btn btn-primary text-right outline" href="/CEPA/index.php" alt="home">Return to Site</a>
        <?php include 'includes/footer.php' ?>
    </form>

  </div>
