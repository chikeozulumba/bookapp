<!-- Top Navigation-->
<?php
$sql = "SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);
 ?>
<style media="screen">
  .navbar {
    background-color:  #666666;

  }
  #title{
    color: #ffffff;
  }
#navbar4{
  color: #ffffff;
}
</style>
<nav class="navbar navbar-default navbar-fixed-top " role="navigation">

  <div class="container-fluid">
    <div class="col-md-12 text-center">
      <div class="">
        <a href="index.php" id="title" class="navbar-brand" style="font-family: 'Alegreya', serif;">CEPA-Bookshop</a>
      </div>
      <div class="nav navbar-nav">
      <ul style="font-family: 'Lora', serif; color: #ffffff;" class="nav navbar-nav navbar-header" id="navbar4"><strong>
      <?php while ($parent = mysqli_fetch_assoc($pquery)) :  ?>
        <?php
        $parent_id = $parent ['id'];
        $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
        $cquery = $db->query($sql2);
        ?>
        </strong>

        <!--Menu Items-->
        <li class="dropdown">
          <a style="font-family: 'Eczar', serif; color: #ffffff;" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']; ?><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <?php while ($child = mysqli_fetch_assoc($cquery)) : ?>
            <li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
          <?php endwhile; ?>
          </ul>
        </li>
      <?php endwhile; ?>
        <li><a style="color: #ffffff;" href="author.php">AUTHORS</a></li>
        <li ><a style="color: #ffffff;" href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a></li>
      </ul>
      </div>
    </div>
  </div>
</nav>
