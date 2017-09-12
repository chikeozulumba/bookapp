<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/CEPA/core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  $sq1 = ("SELECT * FROM products WHERE deleted = 1");
  $presults = $db->query($sq1);
//  $deleted_id = $product['id'];

// restore_id
if (isset($_GET['restore'])) {
  $id = sanitize($_GET['restore']);
  $db->query("UPDATE products SET featured = 1 WHERE id = '$id'");
  $db->query("UPDATE products SET deleted = 0 WHERE id = '$id'");
  header('Location: archived.php');
}
if (isset($_GET['delete'])) {
  $id = sanitize($_GET['delete']);
  $db->query("DELETE FROM products WHERE id = '$id'");
  header('Location: archived.php');
}


//restore featured



 ?>
 <h1 class="text-center" style="font-family: 'Trirong', serif;">Archived Products</h1>
 <hr><div class="clearfix"></div>
 <table class="table table-bordered table-condensed table-striped">
   <thead style="font-family: 'Trirong', serif;"><th></th><th>Product</th><th>Price</th><th>Category</th><th>Sold</th></thead>
   <tbody style="font-family: 'Slabo 27px', serif;">
     <?php while($product = mysqli_fetch_assoc($presults)):
        $deleted_id = $product['id'];
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

         <td>
           <a href="archived.php?restore=<?=$product['id'];?>" class="btn btn-xs btn-info "><span class="glyphicon glyphicon-refresh"></span></a>
           <a href="archived.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-danger "><span class="glyphicon glyphicon-remove"></span></a>
         </td>
         <td><?php echo $product['title']; ?></td>
         <td><?php echo money($product['price']); ?></td>
         <td><?php echo $category;?></td>
         <td>0</td>

       </tr>
     <?php endwhile; ?>
   </tbody>

 </table>

</table>
