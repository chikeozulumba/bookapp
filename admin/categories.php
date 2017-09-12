<?php
  require_once $_SERVER['DOCUMENT_ROOT']. '/CEPA/core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

  $sql = "SELECT * FROM categories WHERE parent = 0";
  $result = $db->query($sql);
  $errors = array();
  $category = '';
  $post_parent = '';

  // Edit category
  if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $edit_sql = "SELECT * FROM categories WHERE id = '$edit_id'";
    $edit_result = $db->query($edit_sql);
    $edit_category = mysqli_fetch_assoc($edit_result);
  }

  //delete category
  if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    $dsql = "SELECT * FROM categories WHERE id = '$delete_id'";
    $result = $db->query($dsql);
    $category = mysqli_fetch_assoc($result);
    if($category['parent'] == 0){
      $sql = "DELETE FROM categories WHERE parent = '$delete_id'";
      $db->query($sql);
    }
    $dsql = "DELETE FROM categories WHERE id = '$delete_id'";
    $db->query($dsql);
    header('Location: categories.php');
    }

  // Process Form
  if (isset($_POST) && !empty($_POST)) {
    $post_parent = sanitize($_POST['parent']);
    $category = sanitize($_POST['category']);
    $sqlform = "SELECT * FROM categories WHERE category = '{$category}' AND parent = '{$post_parent}'";
    if (isset($_GET['edit'])) {
      $id = $edit_category['id'];
      $sqlform = "SELECT * FROM categories WHERE category = '{$category}' AND parent = '{$post_parent}' AND id != '{$id}'";
    }
    $fresult = $db->query($sqlform);
    $count = mysqli_num_rows($fresult);
    // If category is blank
    if ($category == '') {
      $errors[] .= 'The category cannot be left blank.';
    }

    // IF EXISTS IN DATABASE
    if ($count > 0) {
      $errors[] .= $category. ' already exists. Please choose a new category.';
    }

    // Display errors or update database
    if (!empty($errors)) {
      // Display errors
      $display = display_errors($errors); ?>
      <script>
        jQuery('document').ready(function(){
          jQuery('#errors').html('<?php echo $display ?>');
        });
      </script>
    <?php }else {
      // Update database
      $update_sql = "INSERT INTO categories (category,parent) VALUES ('$category','$post_parent')";
      if (isset($_GET['edit'])) {
        $update_sql = "UPDATE categories SET category = '{$category}', parent = '{$post_parent}', WHERE id = '{$edit_id}' ";
      }
      $db->query($update_sql);
      header('Location: categories.php');
    }
  }
  $category_value = '';
  $parent_value = 0;
  if (isset($_GET['edit'])) {
    $category_value = $edit_category['category'];
    $parent_value = $edit_category['parent'];
  }else {
    if (isset($_POST)) {
      $category_value = $category;
      $parent_value = $post_parent;
    }
  }
 ?>

<h2 class="text-center" style="font-family: 'Trirong', serif;">Categories</h2><hr>
<div class="row">

  <!-- FORM-->
  <div class="col-md-6">
    <form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
      <legend style="font-family: 'Trirong', serif;"><?=((isset($_GET['edit']))?'Edit':'Add a');?> Category</legend>
      <div id="errors"></div>
      <div class="form-group">
        <label style="font-family: 'Trirong', serif;" for="parent">Parent</label>
        <select style="font-family: 'Trirong', serif;" class="form-control" name="parent" id="parent">
          <option style="font-family: 'Trirong', serif;" value="0"<?=(($parent_value==0)?' selected="selected"':'');?>>Parent</option>
          <?php while($parent=mysqli_fetch_assoc($result)): ?>
            <option style="font-family: 'Trirong', serif;" value="<?=$parent['id']?>"<?=(($parent_value==$parent['id'])?' selected="selected"':'');?>><?php echo $parent['category'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label style="font-family: 'Trirong', serif;" for="category">Category</label>
        <input style="font-family: 'Trirong', serif;" type="text" class="form-control" name="category" value="<?=$category_value?>" id="category">

      </div>
      <div class="form-group">
        <a style="font-family: 'Trirong', serif;" class="btn btn-warning outline" href="categories.php">Cancel</a>
        <input style="font-family: 'Trirong', serif;" type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Category" class="btn btn-success text-center outline">
      </div>
    </form>
  </div>

  <!-- CATEGORY TABLE-->
  <div class="col-md-6">
    <table class="table table-bordered">
      <thead style="font-family: 'Trirong', serif;">
        <th>Category</th><th>Parent</th><th></th>
      </thead>
      <tbody style="font-family: 'Trirong', serif;">
        <?php
        $sql = "SELECT * FROM categories WHERE parent = 0";
        $result = $db->query($sql);

         while($parent = mysqli_fetch_assoc($result)):
            $parent_id = (int)$parent['id'];
            $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
            $cresult = $db->query($sql2);
          ?>
            <tr class="bg-primary">
              <td><?php echo $parent['category']; ?></td>
              <td>Parent</td>
              <td>
                <a href="categories.php?edit=<?= $parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="categories.php?delete=<?= $parent['id'];?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove-sign"></span></a>
              </td>
            </tr>
            <?php while($child = mysqli_fetch_assoc($cresult)): ?>
              <tr class="bg-info">
                <td><?php echo $child['category']; ?></td>
                <td><?php echo $parent['category']; ?></td>
                <td>
                  <a href="categories.php?edit=<?= $child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                  <a href="categories.php?delete=<?= $child['id'];?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove-sign"></span></a>
                </td>
              </tr>
            <?php endwhile; ?>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
