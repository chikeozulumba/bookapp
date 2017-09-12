<?php
  require_once '../core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  if (!has_permission('admin')) {
    permission_error_redirect('index.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  //--get authors from database!
  $sql = "SELECT * FROM author ORDER BY author";
  $results = $db->query($sql);
  $errors = array();
  //Edit authors
  if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql2 = "SELECT * FROM author WHERE id = '$edit_id'";
    $edit_result = $db->query($sql2);
    $eAuthor = mysqli_fetch_assoc($edit_result);
  }
  //Delete authors
  if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql= "DELETE FROM author WHERE id = '$delete_id'";
    $db->query($sql);
    header('Location: author.php');
  }
  // If addForm is submitted do whatever is below this
  if (isset($_POST['add_submit'])) {
    $author=sanitize($_POST['author']);
    // check if brand is blank
    if ($_POST['author']=='') {
      $errors[] .='You must enter an Author';
    }
    // check if author exists in database
    $sql = "SELECT * FROM author WHERE author = '$author'";
    if(isset($_GET['edit'])){
      $sql = "SELECT * FROM author WHERE author = '$author' AND id != '$edit_id'";
    }
    $result=$db->query($sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      $errors[] .= $author.' already exists please choose another Author name...';
    }

    // display errors
    if (!empty($errors)) {
      echo display_errors($errors);
    }else {
      // Add brand to database
      $sql = "INSERT INTO author (author) VALUES ('$author')";
      if (isset($_GET['edit'])) {
        $sql = "UPDATE author SET author = '$author' WHERE id = '$edit_id'";
      }
      $db->query($sql);
      header('Location: author.php');

    }
  }
 ?>

<h2 style="font-family: 'Trirong', serif;" class="text-center">Authors</h2><hr>
<!--Author FORM-->
<div class="text-center">
  <form class="form-inline" action="author.php<?=((isset($_GET['edit']))?'?edit='. $edit_id:'');?>" method="post">
    <div class="form-group">
      <!--Gives database-->
      <?php
      $author_value = '';
      if (isset($_GET['edit'])) {
        $author_value = $eAuthor['author'];
      }else {
        if (isset($_POST['author'])) {
          $author_value = sanitize($_POST['author']);
        }
      } ?>

      <label style="font-family: 'Trirong', serif;" for="author"><?=((isset($_GET['edit']))?'Edit':'Add an');?> Author: </label>
      <input style="font-family: 'Trirong', serif;" type="text" placeholder="Enter name of Author" name="author" id="author" class="form-control"
          value="<?php echo $author_value; ?>">
      <?php if (isset($_GET['edit'])): ?>
          <a style="font-family: 'Trirong', serif;" href="author.php" class="btn btn-default outline">Cancel</a>
      <?php endif; ?>
      <input style="font-family: 'Trirong', serif;" type="submit" name="add_submit" value="<?php echo ((isset($_GET['edit']))?'Edit':'Add'); ?> Author" class="btn btn-success outline">
    </div>
  </form><hr>
</div>
<table class="table table-bordered table-striped table-condensed" style="width: auto; margin: 0 auto;">
  <thead style="font-family: 'Trirong', serif;">
    <th></th><th class="text-center">Author's list</th><th></th>
  </thead>
  <tbody style="font-family: 'Trirong', serif;">
  <?php while ($author2= mysqli_fetch_assoc($results)): ?>
        <tr>
          <td><a href="author.php?edit=<?php echo $author2['id']; ?>"  class="btn btn-xs btn-default "><span class="glyphicon glyphicon-pencil"></span></a></td>
          <td><?php echo $author2['author']; ?></td>
          <td><a href="author.php?delete=<?php echo $author2['id']; ?>"  class="btn btn-xs btn-default "><span class="glyphicon glyphicon-remove-sign"></span></a></td>
        </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php
  include 'includes/footer.php';
?>
