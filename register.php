<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';


  $title = ((isset($_POST['title']))?sanitize($_POST['title']):'');
  $Fname = ((isset($_POST['first_name']))?sanitize($_POST['first_name']):'');
  $Lname = ((isset($_POST['last_name']))?sanitize($_POST['last_name']):'');
  $Aname = ((isset($_POST['author_name']))?sanitize($_POST['author_name']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $phone = ((isset($_POST['phone_number']))?sanitize($_POST['phone_number']):'');
  $address = ((isset($_POST['street']))?sanitize($_POST['street']):'');
  $highQ = ((isset($_POST['highest_qualification']))?sanitize($_POST['highest_qualification']):'');
  $school = ((isset($_POST['institution']))?sanitize($_POST['institution']):'');
  $course = ((isset($_POST['course']))?sanitize($_POST['course']):'');
  $work = ((isset($_POST['occupation']))?sanitize($_POST['occupation']):'');
  $city = ((isset($_POST['city']))?sanitize($_POST['city']):'');
  $country = ((isset($_POST['country']))?sanitize($_POST['country']):'');
  $state = ((isset($_POST['state']))?sanitize($_POST['state']):'');
  $price = ((isset($_POST['bundle']))?sanitize($_POST['bundle']):'');
  $errors = array();
 ?>
<div class="container" style="font-family: 'Trirong', serif;">
  <div style="background-color: #fff;">
  <div class="col-md-10"  id="login-form">
    <div id="bakd">
    <h2 class="text-center page-header">Author Registration</h2>
    <div >
      <?php
      if ($_POST){
        $emailQ = $db->query("SELECT * FROM author_registered WHERE email = '$email'");
        $emailCount = mysqli_num_rows($emailQ);

        if ($emailCount != 0) {
          $errors[] = 'Email already registered.';
        }

        $authorQ = $db->query("SELECT * FROM author_registered WHERE author_name = '$Aname'");
        $authorCount = mysqli_num_rows($authorQ);

        if ($authorCount != 0) {
          $errors[] = 'Author name already used, please re-enter a unique name.';
        }

        $authorP = $db->query("SELECT * FROM author_registered WHERE phone_number = '$phone'");
        $PCount = mysqli_num_rows($authorP);

        if ($PCount != 0) {
          $errors[] = 'Phone number already registered, please retry.';
        }

        $required = array('title', 'first_name', 'last_name', 'author_name', 'email', 'phone_number', 'street', 'highest_qualification', 'institution', 'course', 'occupation', 'city', 'state', 'country', 'bundle');
        foreach ($required as $f) {
          if (empty($_POST[$f])) {
            $errors[] = 'You must fill out all fields.';
            break;
          }
        }
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
          $errors[] = 'You must enter a valid email address.';
        }
        if (!empty($errors)) {
          echo display_errors($errors);
        }
      };
       ?>
    </div>
    <h5 class="text-center"><p>
      ***By registering on CEPA-Bookshop, you have read and agreed with <a class="text-info" href="terms.php">Terms and conditions</a> the site.***</p></h5>
    <form style="padding-top: 10px;"  method="post" action="" target="">
      <div class="form-group col-md-6" >
        <label for="title">Title:</label>
        <select class="form-control" name="title">
          <option value=""></option>
          <option value="Prof."<?=(($title == 'Prof.')?' selected':'');?>>Prof.</option>
          <option value="Dr."<?=(($title == 'Dr.')?' selected':'');?>>Dr.</option>
          <option value="Mr."<?=(($title == 'Mr.')?' selected':'');?>>Mr.</option>
          <option value="Mrs."<?=(($title == 'Mrs.')?' selected':'');?>>Mrs.</option>
          <option value="Ms."<?=(($title == 'Ms.')?' selected':'');?>>Ms.</option>
        </select>
      </div>

      <div class="form-group col-md-6" >
        <label for="first_name">First Name:</label>
        <input class="form-control" id="first_name" name="first_name" type="text" value="<?=$Fname;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="last_name">Last Name:</label>
        <input class="form-control" id="last_name" name="last_name" type="text" value="<?=$Lname;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="author_name">Author Name:</label>
        <input class="form-control" id="author_name" name="author_name" type="text" value="<?=$Aname;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="email">Email:</label>
        <input class="form-control" id="email" name="email" type="email" value="<?=$email;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="phone_number">Phone Number:</label>
        <input class="form-control" id="phone_number" name="phone_number" type="phone_number" value="<?=$phone;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="street">Address:</label>
        <input class="form-control" id="street" name="street" type="text" value="<?=$address;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="highest_qualification">Highest qualification:</label>
        <input class="form-control" id="highest_qualification" name="highest_qualification" type="text" value="<?=$highQ;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="course">Course studied:</label>
        <input class="form-control" id="course" name="course" type="text" value="<?=$course;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="institution">Institution attended:</label>
        <input class="form-control" id="institution" name="institution" type="text" value="<?=$school;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="occupation">Occupation:</label>
        <input class="form-control" id="occupation" name="occupation" type="text" value="<?=$work;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="city">City:</label>
        <input class="form-control" id="city" name="city" type="text" value="<?=$city;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="state">State:</label>
        <input class="form-control" id="state" name="state" type="text" value="<?=$state;?>">
      </div>

      <div class="form-group col-md-6" >
        <label for="country">Country:</label>
        <input class="form-control" id="country" name="country" type="text" value="<?=$country;?>">
      </div>
      <div class="form-group col-md-6" >
        <label for="bundle">Plan:</label>
        <select placeholder="Choose plan" class="form-control" name="bundle">
          <option  value=""></option>
          <option value="3000"<?=(($price == 3000)?' selected':'');?>>CEPA-Fast ₦3,000</option>
          <option value="7000"<?=(($price == 7000)?' selected':'');?>>CEPA-Smile ₦7,000</option>
          <option value="15000"<?=(($price == 15000)?' selected':'');?>>CEPA-Grow ₦15,000</option>
        </select>
      </div>
      <div class="clearfix">
      <div class="col-md-6 text-right form-group" style="margin-top: 19px;">
        <button  class="btn btn-md btn-warning gradient"><a href="index.php" style="color: white; text-decoration: none;" >Cancel</a></button>
        <input  class="btn btn-md btn-success gradient" action="author_reg.php" type="submit" value="Sign Up >>"><br>
      </div>
</div>
</form>
</div>
</div>
</div>
<style media="screen">
body{
  background-image: url("/CEPA/img/headerlogo/Documents/glasses.jpg");
  background-size: 100vw 110vh;
  background-attachment: fixed;

}
  #login-form{
    padding-left: 200px;
    padding-top: 20px;
  }
  #bakd{
    width: auto;
    height: auto;
    border: 2px solid #000;
    border-radius: 15px;
    box-shadow: 7px 7px 15px rgba(0,0,0,0.6);
    margin: 8% auto;
    padding: 15px;
    background-color: #fff;
  }
  .reg-btn{
    padding-right: 100px;
  }
</style>
