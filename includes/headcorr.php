<?php
$sql = "SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);
 ?>
<!-- Header -->
<nav class="nav1 nav1-top nav1-fixed-top">
  <div class="nav1-brand">
    <span class="logo-brand">
      <a href="index.php">CEPA-Bookshop</a>
    </span>
  </div>
  <nav class="navclass">
    <ul class="nav-head">
      <?php while ($parent = mysqli_fetch_assoc($pquery)) :  ?>
        <?php
        $parent_id = $parent ['id'];
        $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
        $cquery = $db->query($sql2);
        ?>
        <!-- Dropdown -->
      <li><a href="#"><?php echo $parent['category']; ?><span class="caret"></span></a>
        <ul class="sub-menu">
          <?php while ($child = mysqli_fetch_assoc($cquery)) : ?>
          <li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
          <?php endwhile; ?>
        </ul>
      </li>
      <?php endwhile; ?>
      <li><a href="author.php">AUTHORS</a></li>
      <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>CART</a></li>
    </ul>
  </nav>
</nav>

<script type="text/javascript">
  $(document).ready(function() {
    $('li').hover(function() {
      $(this).find('ul>li').fadeToggle(100);
      $(this).find('ul>li>a').fadeToggle(100);
    });
  });
  $('').find('ul>li>a').fadeToggle(400);
</script>
<style media="screen">
.nav-head ul{
  margin-bottom: 0px;
}
.navclass > ul{
  background-color: #e4b600;
  opacity: 0.8;
  color: #bcbcbf;
  font-size: 16px;
}
ul li li a{
  display: none;
}
ul li li{
  display: none;
  }
ul.sub-menu{
  position: absolute;
  background-color:#e4ba13;
  font-size: 18px;
  color: black;
  list-style-type: none;
  width: 250px;
  padding-left: 0px;
  margin-left: -25px;
  padding-top: 0px;
  overflow-y: hidden;
  border: 2px solid #e4b600;
  border-radius: 1px;
  box-shadow: 5px 15px 25px rgba(0,0,0,0.6);
  background-clip: padding-box;
  z-index: 1000px;
  /*display: none;*/
}

.sub-menu > li > a {
    /*display: block;*/
    padding: 3px 20px;
    clear: both;
    font-weight: 900;
    line-height: 1.42857143;
    /*color: #333;*/
    white-space: nowrap;
}

ul.sub-menu li:hover{
  color: #ffffff;
  background-color: #656565;
}
.navclass li:hover .sub-menu{
  /*opacity: 1;*/
}
ul.sub-menu li{
  padding-left: 25px;
  padding-top: 5px;
  padding-bottom: 5px;
  font-size: 13px;
}
.navclass .sub-menu ul li{
  color: black;
  list-style-type: none;
}
.navclass > ul > li:hover{
  background-color: #e4ba13;
}
.navclass > ul > li{
  text-decoration: none;
  list-style-type: none;
  display: inline-block;
  padding: 5px 25px;
  text-transform: uppercase;
  position: relative;
}
.navclass ul li a:hover{
text-decoration: none;
color: white;

}
.navclass ul li a{
text-decoration: none;
color: black;
}
.nav1-bar-holder ul li ul li{
background-color: #dad6d8;

}
.nav-head{
  margin-bottom: 0px;
}
.nav-head .submenu{
  padding-top: 60px;
}
ul.submenu{
  position: absolute;
  min-width: 155px;
  list-style-type: none;
  padding-left: 0px;
  /*padding-top: 5px;*/
}
ul.submenu li{
  padding-left: 20px;
}
ul li a{
  padding-top: 5px;
  padding-left: 25px;
  text-align: center;
}
.nav1{
  background-color: #e4b600;
  color: white;
  opacity: .9;
  min-height: 0px;
  margin-bottom: 10px;
  border: 1px solid transparent;
  position: relative;
  font-family: 'Bree Serif', serif;
  font-weight: 900;
  font-size: 20px;
  border: 1px solid #e4b600;
  border-radius: 1px;
  box-shadow: 15px 15px 20px rgba(0,0,0,0.6);
}
.nav1-bar-holder{
  width: 100%;
  margin-top: -45px;
  margin-left: 30px;
}
.nav1-bar-holder ul{
  list-style: none;
  margin-left: -35px;
  margin: 0px;
  padding: 0px;
}
.nav1-bar-holder li{
  line-height: 25px;
  /*padding: 0 0 0 55px;*/
}

.nav1-bar-holder ul li a:hover{
  text-decoration: none;
  background-color: #f9fafd;
  color: black;
  opacity: .9;
}

.nav1-bar-holder ul li a{
  text-decoration: none;
  text-align:center;
  text-transform: uppercase;
  margin-top: 20px;
  float: left;
  padding-right: 40px;
  height: 40px;
  color: white;
  font-size: 16px;
  display: block;
}
.nav1-top{
  top: 0;
  border-width: 0 0 1px;
  border-radius: 0;

}
.nav1-fixed-top{
  position: fixed;
  right: 0;
  left: 0;
  z-index: 1030;
}
.nav1-brand{
  font-size: 20px;
  margin-left: 50px;
  margin-top: 10px;
}
.nav1-brand a{
  display: block;
  height: 100%;
}
.nav1-brand a:hover{
  text-decoration: none;
}
.logo-brand{
  margin-top: 5px;
  width: 150px;
  height: 50px;
  background: url(img/headerlogo/logo.png) no-repeat;
  text-indent: -9999px;
  overflow: hidden;
  display: block;
  margin: 0 40px 0px;
}
</style>
