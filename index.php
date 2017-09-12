<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/headerfull.php';
  include 'includes/headcorr.php';
  include 'includes/leftbar.php';
  include 'includes/contactmodal.php';

  $sql = "SELECT * FROM products";
  $featured = $db->query($sql);
 ?>


      <!--Main content-->
      <div class="col-md-8">
        <div class="row">
          <h2 style="font-family: 'Trirong', serif;" class="page-header text-center fadeInDown aniamted">Featured Books</h2>
          <?php while($product = mysqli_fetch_assoc($featured)) : ?>
            <div class="container-a4 col-md-4 text-center">
              <ul class="caption-style-4" style="font-family: 'Lora', serif;">
                <li>
                  <?php $photos = explode(',',$product['image']); ?>
                  <img src="<?=$photos[0];?>" alt="<?php echo $product['title'] ?>" class="img-thumb"/>
                  <div class="caption">
                    <div class="blur">
                      <div class="caption-text">
                      <h5 class="text-center" style="    margin-top: -85px; margin-left: 50px; text-align: center;text-rendering: geometricPrecision; font-size: 16px;"><?php echo $product['title'] ?></h5><br><br>
                      <!-- <p class="list-price" >List Price: ₦ <s><?php echo $product['list_price'] ?></s></p> -->
                      <p class="price" style="margin-top: 35px;margin-left: 50px; text-align: center;text-rendering: geometricPrecision;">Price:<br> ₦ <?php echo $product['price'] ?></p>
                    </div>
                  </div>
                  </div>
                </li>
              </ul><br>
              <div class="clearfix">

              </div>
              <button id="butt" style="font-family: 'Neuton', serif;" type="button" class="btn btn-sm btn-success outline" onclick="detailsmodal(<?= $product['id']; ?>)">
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
<div id="main">
<div id="wrapper">
<div class="wrapper-holder">
<div class="block-advice">
  <div class="advice-holder">
    <h2 style="font-weight: bold; font: bold 30px/30px 'novecentosanswide', Arial, Helvetica, sans-serif; margin-top: 0; padding-top: 16px;">Newsletter</h2>
    <p style="margin-top: -20px;">Join to receive promotions and other good stuff.</p>
  </div>
  <form action="admin/subscribe.php?add=1" method="POST" class="form-newsletter">
    <fieldset>
      <input type="text" name="email" value="" placeholder="Your email..." required/>
      <input class="atn black normal" type="submit" value="Subscribe" />
    </fieldset>
  </form>
</div>
</div>
</div>
</div>
<?php
  #include 'includes/rightbar.php';
  include 'includes/footer.php';
 ?>
 <style media="screen">
 #main {
 	max-width: 1170px;
 	margin: 0 auto;
 	overflow: hidden;
 	position: relative;
   display: block;
 }
 .container-a4 #butt{
   margin-top: 10px;
   margin-bottom: 10px;
   margin-left: -70px;
 }
 img.img-thumb{
     width: 200px;
     height: 250px;
     margin: 15px auto;
 }
 .block-advice {
     margin-bottom: 15px;
     margin-top: 15px;
     border: 0.5px solid #cdcdcd;
     padding: 10px 40px 10px;
     overflow: hidden;
     display: block;
     color: #6e6e6e;
 }
 .block-advice .advice-holder {
     float: left;
     color: #6e6e6e;
     text-transform: uppercase;
     font: 14px/16px 'novecento_sans_widemedium', Arial, Helvetica, sans-serif;
     margin: 0;
     padding: 0;
     border: 0;
     font-size: 100%;
     font: inherit;
     vertical-align: baseline;
 }
 .block-advice h2 {
     font-weight: bold;
     color: #444;
     font: bold 30px/30px 'novecentosanswide', Arial, Helvetica, sans-serif;
     text-transform: uppercase;
     margin: 0;
     padding: 0;
     border: 0;
     font-size: 100%;
     font: inherit;
     vertical-align: baseline;
     display: block;
     font-size: 1.5em;
     -webkit-margin-before: 0.83em;
     -webkit-margin-after: 0.83em;
     -webkit-margin-start: 0px;
     -webkit-margin-end: 0px;
     font-weight: bold;
 }
 .form-newsletter {
    width: 630px;
    float: right;
    margin: 25px 0 0;
}
 #wrapper {
     width: 100%;
     height: 100%;
     display: table;
     margin: 0;
     padding: 0;
     border: 0;
     font-size: 100%;
     font: inherit;
     vertical-align: baseline;
 }
 .wrapper-holder {
     width: 100%;
     display: table-row;
 }
 .form-newsletter input[type=text] {
     float: left;
     width: 418px;
     padding: 11px 10px;
     margin: 0 28px 0 0;
 }
 .form-newsletter input{
   -webkit-rtl-ordering: logical;
   -webkit-user-select: text;
   cursor: auto;
   text-rendering: auto;
   text-rendering: auto;
   color: initial;
   letter-spacing: normal;
   word-spacing: normal;
   text-transform: none;
   text-indent: 0px;
   text-shadow: none;
   display: inline-block;
   text-align: start;
   margin: 0em 0em 0em 0em;
   font: 13.3333px Arial;
   -webkit-appearance: textfield;
   background-color: white;
   -webkit-rtl-ordering: logical;
   -webkit-user-select: text;
   cursor: auto;
   padding: 1px;
   border-width: 2px;
   border-style: inset;
   border-color: initial;
 }
 form .form-newsletter input[type=text] {
     background: #fff;
     border: 1px solid #cdcdcd;
     padding: 11px 20px;
     width: 100%;
     outline: none;
     color: #6e6e6e;
     margin: 0;
     text-transform: uppercase;
     font: 14px/16px 'novecento_sans_widemedium', Arial, Helvetica, sans-serif;
     -webkit-appearance: none;
     -webkit-border-radius: 0;
     box-sizing: border-box;-webkit-box-sizing: border-box; -moz-box-sizing: border-box;
 }
 .form-newsletter input[type=submit] {
     float: right;
 }
 button.normal, input[type=submit].normal, .atn.normal {
     width: 182px;
     height: 40px;
     font: 14px/40px 'novecento_sans_widemedium', Arial, Helvetica, sans-serif;
 }
 .atn.black {
     background: #444;
     color: #fff;
 }
 .atn.white {
    background: #fff;
    color: #6e6e6e;
}
 .atn-delete:hover, .atn:hover {
     text-decoration: none;
     opacity: 0.9;
 }
 .form-newsletter button ,input[type=submit], .atn {
     text-transform: uppercase;
     display: block;
     text-align: center;
     border: none;
     padding: 0;
     width: 182px;
     height: 40px;
     background: #444;
     color: #fff;
     font: 14px/40px 'novecento_sans_widemedium', Arial, Helvetica, sans-serif;
 }
 .form-newsletter input[type=submit], button, textarea {
     -webkit-appearance: none;
     -webkit-border-radius: 0;
     box-sizing: border-box;
     -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
 }
 input[type=submit] {
     padding: 0;
     overflow: visible;
     cursor: pointer;
 }
 </style>
