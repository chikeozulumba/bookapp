<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

  // delete id
  if (isset($_GET['delete'])) {
    $id = sanitize($_GET['delete']);
    $db->query("UPDATE products SET featured = 0 WHERE id = '$id'");
    $db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
    header('Location: products.php');
  }

  $dbpath = '';
  if (isset($_GET['add']) || isset($_GET['edit'])) {
  $authorQuery = $db->query("SELECT * FROM author ORDER BY author");
  $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
  $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
  $author = ((isset($_POST['author']) && !empty($_POST['author']))?sanitize($_POST['author']):'');
  $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
  $category = ((isset($_POST['child'])) && !empty($_POST['child'])?sanitize($_POST['child']):'');
  $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
  $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
  $description_text = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
  $format_display = ((isset($_POST['format']) && $_POST['format'] != '')?sanitize($_POST['format']):'');
  $format_display = rtrim($format_display,',');
  $saved_image = '';
    if (isset($_GET['edit'])) {
      $edit_id = (int)$_GET['edit'];
      $product_results = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
      $product = mysqli_fetch_assoc($product_results);
      if (isset($_GET['delete_image'])) {
        $imgi = (int)$_GET['imgi'] - 1;
        $images = explode(',',$product['image']);
        $image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgi];
        unlink ($image_url);
        unset($images[$imgi]);
        $image_string = implode(',',$images);
        $db->query("UPDATE products SET image = '$image_string' WHERE id ='$edit_id'");
        header('Location: products.php?edit='.$edit_id);
      }
      $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
      $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
      $author = ((isset($_POST['author']) && $_POST['author'] != '')?sanitize($_POST['author']):$product['author']);
      $parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
      $parentResult = mysqli_fetch_assoc($parentQ);
      $parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
      $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
      $list_price = ((isset($_POST['list_price']))?sanitize($_POST['list_price']):$product['list_price']);
      $description_text = ((isset($_POST['description']))?sanitize($_POST['description']):$product['description']);
      $format_display = ((isset($_POST['format']) && $_POST['format'] != '')?sanitize($_POST['format']):$product['format']);
      $format_display = rtrim($format_display,',');
      $saved_image = (($product['image'] != '')?$product['image']:'');
      $dbpath = $saved_image;
    }
    if (!empty($format_display)) {
      $formatString = sanitize($format_display);
      $formatString = rtrim($formatString,',');
      $formatArray = explode(',',$formatString);
      $fArray = array();
      $qArray = array();
      $tArray = array();
      foreach ($formatArray as $fs) {
        $f = explode(':', $fs);
        $fArray[] = $f[0];
        $qArray[] = $f[1];
        #$tArray[] = $f[2];echo $tArray;
      }
    }else {$formatArray = array();}

  if ($_POST) {
    //dbpath= '';
    $errors = array();
    $required = array('title','author','price','parent','child','format');
    $allowed = array('png','jpg','jpeg','gif');
    $uploadPath = array();
    $tmpLoc = array();
    foreach ($required as $field) {
      if ($_POST[$field] == '') {
        $errors[] = 'All fields with an Asterisk(*) are required';
        break;
      }
    }
    #var_dump($_FILES['photo']);die();
    $photo_count = count($_FILES['photo']['name']);#var_dump($_FILES['photo']);
    if ($photo_count > 0) {
      for($i=0;$i<$photo_count;$i++){
        // if ($_FILES['photo']['name'] != '') {
            $name = $_FILES['photo']['name'][$i];
            $nameArray = explode('.',$name);
            $fileName = $nameArray[0];
            $fileExt = $nameArray[1];
            $mine = explode('/',$_FILES['photo']['type'][$i]);
            $mineType = $mine[0];
            $mineExt = $mine[1];
            $tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
            $fileSize = $_FILES['photo']['size'][$i];
            $uploadName = md5(microtime().$i).'.'.$fileExt;
            $uploadPath[] = BASEURL.'images/products/'.$uploadName;
            if ($i != 0) {
              $dbpath .= ',';
            }
            $dbpath .= '/CEPA/images/products/'.$uploadName;
            if ($mineType != 'image') {
              $errors[] = 'The file MUST be an image.';
            }
            if (!in_array($fileExt, $allowed)) {
              $errors[] = 'The file extension must be of png, jpg, jpeg, or gif format';
            }
            if ($fileSize > 15000000) {
              $errors[] = 'The file size must be under 15MB.';
            }
            if ($fileExt != $mineExt && ($mineExt == 'jpeg' && $fileExt != 'jpg')) {
              $errors[] = 'File extension does not match the file';
            }
          }
    }

    if (!empty($errors)) {
      echo display_errors($errors);
    }else {
      // upload file and insert into database
        if ($photo_count > 0) {
          for ($i=0; $i < $photo_count; $i++) {
            move_uploaded_file($tmpLoc[$i],$uploadPath[$i]);
          }
       }
      $insertSql = "INSERT INTO products (title,price,list_price,author,categories,format,image,description)
       VALUES ('{$title}','{$price}','{$list_price}','{$author}','{$category}','{$format_display}','{$dbpath}','{$description_text}')";
       if (isset($_GET['edit'])) {
         // newly edited if not working remove from tmploc to uploadname
         $insertSql = "UPDATE products SET title = '$title', price = '$price', list_price = '$list_price',
         author = '$author', categories = '$category', format = '$format_display', image = '$dbpath', description = '$description_text' WHERE id ='$edit_id'" ;
       }
       $db->query($insertSql);
       header('Location: products.php');
    }
  }
?>
  <h2 class="text-center" style="font-family: 'Trirong', serif;"><?=((isset($_GET['edit']))?'Edit':'Add a New');?> Book</h2><hr>
  <form class="" action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
    <div class="form-group col-md-3">
      <label for="title" style="font-family: 'Slabo 27px', serif;">Title* :</label>
      <input style="font-family: 'Trirong', serif;" type="text" name="title" id="title" class="form-control" value="<?=$title;?>">
    </div>

    <div class="form-group col-md-3">
      <label for="author" style="font-family: 'Slabo 27px', serif;">Author* :</label>
      <select style="font-family: 'Trirong', serif;" class="form-control" id="author" name="author">
        <option style="font-family: 'Trirong', serif;" value=""<?=(($author == '')?' selected':'');?>></option>
        <?php while($a = mysqli_fetch_assoc($authorQuery)): ?>
          <option style="font-family: 'Trirong', serif;" value="<?=$a['id'];?>"<?=(($author == $a['id'])?' selected':'');?>><?= $a['author'];?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="parent" style="font-family: 'Slabo 27px', serif;">Parent Category* :</label>
      <select style="font-family: 'Trirong', serif;" class="form-control" id="parent" name="parent">
        <option value=""<?=(($parent == '')?' selected':'');?>></option>
        <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
          <option value="<?=$p['id'];?>"<?=(($parent == $p['id'])?' selected':'');?>><?=$p['category'];?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="child" style="font-family: 'Slabo 27px', serif;">Child Category* :</label>
      <select style="font-family: 'Trirong', serif;" id="child" class="form-control" name="child"></select>
    </div>

    <div class="form-group col-md-3">
      <label for="price" style="font-family: 'Slabo 27px', serif;">Price* :</label>
      <input style="font-family: 'Trirong', serif;" class="form-control" id="price" type="text" name="price" value="<?=$price;?>">
    </div>

    <div class="form-group col-md-3">
      <label for="list_price" style="font-family: 'Slabo 27px', serif;">List Price :</label>
      <input style="font-family: 'Trirong', serif;" class="form-control" id="list_price" type="text" name="list_price" value="<?=$list_price?>">
    </div>

    <div class="form-group col-md-3">
      <label style="font-family: 'Slabo 27px', serif;">Quantity & Format:</label>
      <button style="font-family: 'Trirong', serif;" class="btn btn-warning form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity</button>
    </div>

    <div class="form-group col-md-3">
      <label for="price" style="font-family: 'Slabo 27px', serif;">Qty & Format Preview :</label>
      <input style="font-family: 'Trirong', serif;" class="form-control" id="formats" type="text" name="format" value="<?=$format_display;?>" readonly>
    </div>

    <div class="form-group col-md-6">
      <?php if ($saved_image != ''): ?>
        <?php
          $imgi = 1;
          $images = explode(',',$saved_image);?>
          <?php foreach($images as $image):?>
        <div class="saved-image col-md-4">
          <img src="<?=$image;?>" alt="saved image" /><br>
          <a href="products.php?delete_image=1&edit=<?=$edit_id;?>&imgi=<?=$imgi;?>" class="text-danger outline" style="font-family: 'Slabo 27px', serif;">Delete Image</a>
        </div>
      <?php
        $imgi++;
      endforeach; ?>
      <?php else: ?>
      <label for="photo" style="font-family: 'Slabo 27px', serif;">Product Photo*:</label>
      <input style="font-family: 'Trirong', serif;"type="file" name="photo[]" id="photo" class="form-control" multiple>
    <?php endif; ?>
    </div>

    <div class="form-group col-md-6">
      <label for="description" style="font-family: 'Slabo 27px', serif;">Description:</label>
      <textarea style="font-family: 'Trirong', serif;" id="description" name="description" class="form-control" rows="6" cols="40"><?=$description_text;?></textarea>
    </div>

    <div class="form-group pull-right">
      <a href="products.php" class="btn btn-default outline " style="font-family: 'Slabo 27px', serif;">Cancel</a>
      <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add ');?> Book" class=" btn btn-success outline">
    </div><div class="clearfix"></div>
  </form>

  <!-- Modal -->
<div class="modal fade "  id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Quantity</h4>
      </div>
      <div style="font-family: 'Trirong', serif;" class="modal-body ">
        <div class="container-fluid">
          <?php for($i=1;$i<=12;$i++): ?>
            <div class="form-group col-md-2">
              <label for="format<?=$i;?>" style="font-family: 'Slabo 27px', serif;">Format : </label>
              <input type="text" name="format<?=$i;?>" id="format<?=$i;?>" value="<?=((!empty($fArray[$i-1]))?$fArray[$i-1]:'');?>" class="form-control">
            </div>
            <div class="form-group col-md-2">
              <label for="qty<?=$i;?>" style="font-family: 'Slabo 27px', serif;">Quantity : </label>
              <input type="number" name="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" id="qty<?=$i;?>" min="0" class="form-control">
            </div>
            <div class="form-group col-md-2">
              <label for="threshold<?=$i;?>" style="font-family: 'Slabo 27px', serif;">Threshold : </label>
              <input type="number" name="threshold<?=$i;?>" value="<?=((!empty($tArray[$i-1]))?$tArray[$i-1]:'');?>" id="threshold<?=$i;?>" min="0" class="form-control">
            </div>
          <?php endfor; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default outline" style="font-family: 'Slabo 27px', serif;" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary outline" style="font-family: 'Slabo 27px', serif;" onclick="updateformat();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php }else { #All THIS WOULD HAPPEN
  $sql = "SELECT * FROM products WHERE deleted = 0";
  $presults = $db->query($sql);
  if (isset($_GET['featured'])) {
    $id = (int)$_GET['id'];
    $featured = (int)$_GET['featured'];
    $featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
    $db->query($featuredSql);
    header('Location: products.php');
  }
 ?>
<h2 class="text-center" style="font-family: 'Trirong', serif;">Book Collections</h2>
<a href="products.php?add=1" class="btn btn-success pull-right outline" id="add-product-btn" style="font-family: 'Slabo 27px', serif;"><strong>Add Book</strong></a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <thead style="font-family: 'Slabo 27px', serif;"><th>Edit</th><th>Books</th><th>Price Total</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
  <tbody style="font-family: 'Slabo 27px', serif;">
    <?php while($product = mysqli_fetch_assoc($presults)):
        $childID = $product['categories'];
        $catSQL = "SELECT * FROM categories WHERE id = '$childID'";
        $result = $db->query($catSQL);
        $child = mysqli_fetch_assoc($result);
        $parentID = $child['parent'];
        $pSQL = "SELECT * FROM categories WHERE id = '$parentID'";
        $presult = $db->query($pSQL);
        $parent = mysqli_fetch_assoc($presult);
        $category = $parent['category'].' --> '.$child['category'];
      ?>
      <tr>
        <td>
          <a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
          <a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-remove"></span></a>
        </td>
        <td><?php echo $product['title']; ?></td>
        <td><?php echo money($product['price']); ?></td>
        <td><?php echo $category;?></td>
        <td><a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class=" btn btn-xs btn-info">
          <span class="glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus');?>"></span></a>
          &nbsp <?=(($product['featured'] == 1)?'Featured Book':'Not Featured'); ?></td>
        <td>0</td>

      </tr>
    <?php endwhile; ?>
  </tbody>

</table>

<?php } include 'includes/footer.php'; ?>
<script>
  jQuery('document').ready(function(){
    get_child_options('<?=$category?>');

  });
</script>
