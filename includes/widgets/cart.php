<h3 style="font-family: 'Trirong', serif;" class="text-center">Shopping Cart</h3>

<div>
<?php if(empty($cart_id)): ?>
<p class="text-center" style="font-family: 'Trirong', serif;"> Your Shopping Cart is empty.</p>

<?php else:
    $CartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $results = mysqli_fetch_assoc($CartQ);
    $items = json_decode($results['items'],true);
    $sub_total = 0;
  ?>
<table class="table table-condensed" id="cart_widget" style="font-family: 'Trirong', serif; font-size: 12px;">
  <tbody>
    <?php
      foreach ($items as $item):
          $productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}'");
          $product = mysqli_fetch_assoc($productQ);

      ?>
      <?php if ($item['quantity'] && $product['title'] != ''): ?>
        <tr>
          <td><?=$item['quantity'];?></td>
          <td><?=substr($product['title'],0,15);?></td>
          <td><?=money($item['quantity'] * $product['price']);?></td>
        </tr>
      <?php endif; ?>
    <?php

        $sub_total += ($item['quantity'] * $product['price']);
    endforeach;
  ?>
    <tr>
      <td></td>
      <td>Sub Total</td>
      <td><?=money($sub_total);?></td>
    </tr>

  </tbody>
</table>
<a href="cart.php" style="font-family: 'Trirong', serif;" class="btn btn-xs btn-primary pull-right outline"><h6>View Cart</h6></a>
<div class="clearfix"></div>
<?php endif; ?>
</div>
<style media="screen">

</style>
