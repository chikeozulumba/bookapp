<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/headerpartial.php';
  include 'includes/navigation.php';
  include 'includes/leftbar.php';
  include 'includes/contactmodal.php';

  $sql = "SELECT * FROM products";
  $cat_id = (($_POST['cat'] != '')?sanitize($_POST['cat']):'');
  if ($cat_id == '') {
    $sql .= " WHERE deleted = 0";
  }else {
    $sql .= " WHERE categories = '{$cat_id}' AND deleted = 0";
  }
  $price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
  $min_sort = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
  $max_sort = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
  $author = (($_POST['author'] != '')?sanitize($_POST['author']):'');
  if ($min_price != '') {
    $sql .= " AND price >= '{$min_price}'";
  }
  if ($max_price != '') {
    $sql .= " AND price <= '{$max_price}'";
  }
  if ($author != '') {
    $sql .= " AND author = '{$author}'";
  }
  if ($price_sort == 'low') {
    $sql .= " ORDER BY price";
  }
  if ($price_sort == 'high') {
    $sql .= " ORDER BY price DESC";
  }
  $productQ = $db->query($sql);
  $category = get_category($cat_id);
 ?>

      <!--Main content-->
      <div class="col-md-8">
        <div class="row">
        <?php if($cat_id != ''): ?>
          <h2 style="font-family: 'Trirong', serif;"  class="text-center"><?=$category['parent'].' ▶ '. $category['child'];?></h2>
        <?php else: ?>
          <h2 style="font-family: 'Trirong', serif;"  class="text-center">CEPA-Bookshop</h2>
        <?php endif; ?>
          <?php while($product = mysqli_fetch_assoc($productQ)) : ?>
            <div class="col-lg-3 text-center">
              <h4 style="font-family: 'Slabo 27px', serif;" class="text-center"><strong><?php echo $product['title'] ?></strong></h4>
              <?php $photos = explode(',',$product['image']); ?>
              <img style="width: 70%; margin: 25px auto;" src="<?php echo $photos[0]; ?>" alt="<?php echo $product['title'] ?>" class="img-thumb"/>
              <p class="list-price text-danger" style="font-family: 'Lora', serif;">List Price: ₦ <s><?php echo $product['list_price'] ?></s></p>
              <p class="price" style="font-family: 'Lora', serif;">Price: ₦ <?php echo $product['price'] ?></p>
              <button style="font-family: 'Neuton', serif;" type="button" class="btn btn-sm btn-success outline" onclick="detailsmodal(<?= $product['id']; ?>)">
                Book details</button>
            </div>
        <?php endwhile; ?>
        </div>
      </div>

    <?php
      include 'includes/rightbar.php';
      #include 'includes/footer.php';
     ?>
   </div>
   <?php
     #include 'includes/rightbar.php';
     include 'includes/footer.php';
    ?>
     <style media="screen">
     #partialheaderWrapper{
       position: relative;
       padding: 0;
       margin: 0;
       overflow: hidden;
       height: 180px;
       background-image: url(img/headerlogo/bkd3.jpg);
       background-repeat: no-repeat;
       background-size: 100% 500px;
       background-position: top center;
       background-attachment: fixed;
     }

     #partiallogotext{
       position: absolute;
       width: 100%;
       height: 260px;
       background-image: url(img/headerlogo/2text.png);
       background-repeat: no-repeat;
       background-position: center;
       background-size: 70% 500px;
       top: 50%;
       margin-top: -90px;
     }
       #productPhoto img{
         width: 70%;
         margin: 25px auto;
       }

     </style>
