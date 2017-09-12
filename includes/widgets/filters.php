<?php
  $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
  $price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
  $min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
  $max_price = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');

  $b = ((isset($_REQUEST['author']))?sanitize($_REQUEST['author']):'');
  $authorQ = $db->query("SELECT * FROM author ORDER BY author");
 ?>
<h3 style="font-family: 'Trirong', serif;" class="text-center">Sort by:</h3>
<h4  style="font-family: 'Trirong', serif;" class="text-center">Price</h4><br>
<form style="font-family: 'Trirong', serif;" class="form-inline" action="search.php" method="post">
  <input type="hidden" name="cat" value="<?=$cat_id?>">
  <input type="hidden" name="price_sort" value="0">
  <input type="radio" name="price_sort" value="low"<?=(($price_sort == 'low')?' checked':'');?>>Low to High<br>
  <input type="radio" name="price_sort" value="high"<?=(($price_sort == 'high')?' checked':'');?>>High to Low<br><br>
  <input type="text" name="min_price" class="price-range" placeholder="Min ₦" value="<?=$min_price;?>">To
  <input type="text" name="max_price" class="price-range" placeholder="Max ₦" value="<?=$max_price;?>"><br><br>
  <h4 class="text-center"> Authors </h4>
  <input type="radio" name="author" value=""<?=(($b == '')?' checked':'');?>>All<br/>
  <?php while($author = mysqli_fetch_assoc($authorQ)): ?>
    <input type="radio" name="author" value="<?=$author['id'];?>"<?=(($b == $author['id'])?' checked':'');?>><?=$author['author'];?><br>
  <?php endwhile; ?><br>
<button type="submit" name="name" value="Search" style="font-family: 'Trirong', serif;" class="btn btn-md btn-primary outline">Search &#x1f50e;</button>
</form>
<style media="screen">
  input.price-range {
    width: 55px;
  }
</style>
