<h3 class="text-center" style="font-family: 'Trirong', serif;">Popular Books</h3>
<?php
  $transQ = $db->query("SELECT * FROM cart WHERE paid = 1 ORDER BY id DESC LIMIT 7");
  $results = array();
  while ($row = mysqli_fetch_assoc($transQ)) {
    $results[] = $row;
  }
  $row_count = $transQ->num_rows;
  $used_ids = array();
  for ($i=0;$i<$row_count;$i++) {
    $json_items = $results[$i]['items'];
    $items = json_decode($json_items,true);
    foreach ($items as $item) {
      if (!in_array($item['id'], $used_ids)) {
        $used_ids[] = $item['id'];
      }
    }
  }
 ?>
<div class="" id="recent_widget">
  <table class="table table-condensed table-stripped">
    <?php foreach ($used_ids as $id):
        $productQ = $db->query("SELECT id,title FROM products WHERE id = '{$id}'");
        $product = mysqli_fetch_assoc($productQ);
     ?>
     <?php if ($product['title'] != ''):?>
     <tr>
       <td style="font-family: 'Trirong', serif; font-size: 13px;">
         <?=substr($product['title'],0,15);?>
       </td>
       <td>
         <a style="font-family: 'Lora', serif; font-size: 9px;" class="text-primary btn btn-xs btn-warning" onclick="detailsmodal('<?=$id;?>')">View</a>
       </td>
     </tr>
   <?php endif; ?>
   <?php endforeach; ?>
  </table>
</div>
