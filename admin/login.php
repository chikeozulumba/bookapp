<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';
  include 'includes/head.php';
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $email = trim($email);
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $password = trim($password);
  $errors = array();
  ?>
  <style media="screen">
  body{
    background-image: url("/CEPA/img/headerlogo/bkgrnd2.jpg");
    background-size: 100vw 110vh;
    background-attachment: fixed;
  }
  </style>
  <div id="login-form">
    <div>
      <?php
        if ($_POST) {
          //form Validation
          if (empty($_POST['email']) || empty($_POST['password'])) {
            $errors[] = 'You must provide email and password!';
          }

          //validate email
          if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'You must enter a valid email';
          }

          //password is more than 6 characters
          if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 chatacters!';
          }


          //Check if email exists
          $query = $db->query("SELECT * FROM users WHERE email = '$email'");
          $user = mysqli_fetch_assoc($query);
          $userCount = mysqli_num_rows($query);
          if ($userCount < 1) {
            $errors[] = 'The User isn\'t registered, contact Admin';
          }
          if (!password_verify($password, $user['password'])) {
            $errors[] = 'The password doesn\'t match, please try again or contact Admin';
          }
          //check for errors
          if (!empty($errors)) {
            echo display_errors($errors);
          }else {
            //log user in
            $user_id = $user['id'];
            login($user_id);
          }
        }
       ?>

    </div>
    <h2 style="font-family: 'Trirong', serif;"style="font-family: 'Trirong', serif;" class="text-center">Login</h2>
    <form action="login.php" method="post">
      <div class="form-group">
        <label style="font-family: 'Trirong', serif;" for="email">Email:</label>
        <input style="font-family: 'Trirong', serif;" type="text" name="email" class="form-control" id="email" value="<?=$email;?>">
      </div>
      <div style="font-family: 'Trirong', serif;" class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" class="form-control" id="password" value="<?=$password;?>">
      </div>
      <div class="form-group">
        <input style="font-family: 'Trirong', serif;" type="submit" class="btn btn-success outline" value="Login">
      </div>

      <a style="font-family: 'Trirong', serif;" class="btn btn-primary text-right outline" href="/CEPA/index.php" alt="home">Return to Site</a>
        <?php include 'includes/footer.php' ?>
    </form>

  </div>
