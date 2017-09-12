<!--footer-->
</div>
</div>
<footer style="font-family: 'Trirong', serif;" class="site-footer text-center footer-fixed-bottom" id="footer">
<div class="container">
  <div class="row">
    <div class="col-md-3 main">
      <h4 class="page-header">HEAD OFFICE</h4>
      <address class="text-center">
        #27 Ochi street, Achara Layout, <br />
        Enugu, P.O. Box 12345 <br />
        Enugu State, <br />
        Nigeria. <br />
      </address>
    </div>
    <div class="col-md-2" style="padding-top: 0px;">
      <h4 class="page-header"> MENU </h4>
      <address class="text-left" id="No1">
          <p><a href="about.php">About Us</a></p>
          <p><a href="pricing.php">Pricing</a></p>
          <p><a href="advancedbooks.php.php">Bulk purchase</a></p>
      </address>
    </div>
    <div class="col-md-2" style="padding-top: 0px;">
      <h4 class="page-header"> SUPPORT </h4>
      <address class="text-left" id="No1">
          <p><a href="privacy.php">Privacy</a></p>
          <p><a href="terms.php">Terms and conditions</a></p>

      </address>
    </div>
    <div class="col-md-5" style="padding-top: 0px;">
  <!--  -->
  <div class="col-xs-7" style="padding-top: 0px;">
    <h4 class="page-header"> SOCIAL </h4>
    <address class="text-left" id="social-media">
        <p><a href="privacy.php"><img src="images/Media/facebook.png" alt="" /> Facebook</a></p>
        <p><a href="terms.php"><img src="images/Media/twitter.png" alt="" /> Twitter</a></p>
        <p><a href="#"><img src="images/Media/Instagram (2).png" alt="" /> Instagram</a></p>
        <p><a href="mailto:journal@cepajournal.com"><img src="images/Media/gmail.png" alt="" /> Gmail</a></p>

    </address>
  </div>
    </div>
    <style media="screen">
      #social-media img{
        height: 20px;
        width: 20px;

      }
      #social-media a{
        font-size: 14px;
        text-decoration: none;
      }
      #social-media a:hover{
        text-decoration: none;
        color: white;

      }

    </style>
  </div>
    <div class="bottom-footer">
      <div class="col-md-4"><p>
        Copyright &copy; Smartlinks-Publishers 2016.
      </p></div>
      <div class="col-md-8">
        <ul class="footer-nav pull-right">
          <li><a href="index.php">HOME</a></li>
          <li><a href="register.php">REGISTER</a></li>
          <li><a href="index.php">ABOUT</a></li>
          <li><a href="#contact" data-toggle="modal">CONTACT US</a></li><br>
        </ul>
      </div>
    </div>
</div>
</footer>


        </div>
      </div>
    <style>
    .main{
      color: #ffffff;
    }
    #No1 a{
      color: #ffffff;
      text-decoration: none;
    }
    #No1 a:hover{
      color: #26e78e;
      text-decoration: none;
    }
    .footer-nav{
      text-align: right;
      list-style: none;
    }
    .footer-nav li{
      display: inline;
    }
    .footer-nav li:not(:first-child):before{
      padding: 0px 10px;
      content: '|';
    }
    .footer-nav a{
      color: #ffffff;
    }
    .footer-nav a:hover{
      color: #26e78e;
      text-decoration: none;
    }
    #footer{
      background-color: #666666;
      color: #ffffff;
      margin-top: 10px;
      padding-top: 10px;
    }
    .bottom-footer{
      border-top: 1px solid #d9d9d9;
      margin-top: 10px;
      padding-top: 12px;
      color: #ffffff;
    }
    </style>
    <script>
      jQuery(window).scroll(function(){
        var vscroll = jQuery(this).scrollTop();
        jQuery('#logotext').css({
          "transform" : "translate(0px, "+vscroll/4+"px)"
        });
      });

      jQuery(window).scroll(function(){
        var vscroll = jQuery(this).scrollTop();
        jQuery('#text').css({
          "transform" : "translate(0px, "+vscroll/3+"px)"
        });
      });

      jQuery(window).scroll(function(){
        var vscroll = jQuery(this).scrollTop();
        jQuery('#know_more').css({
          "transform" : "translate(0px, "+vscroll/6+"px)"
        });
      });


      function detailsmodal(id){
        var data = {'id' : id};
        jQuery.ajax({
          url : '/CEPA/includes/detailsmodal.php',
          method : "post",
          data : data,
          success : function(data){
            jQuery('body').append(data);
            jQuery('#details-modal').modal('toggle');
          },
          error : function(){
            alert("something's wrong")
          }
        });
      }

      function update_cart(mode,edit_id,edit_format){
        var data = {"mode" : mode, "edit_id": edit_id, "edit_format": edit_format};
        jQuery.ajax({
          url : '/CEPA/admin/parsers/update_cart.php',
          method : "post",
          data : data,
          success : function(){location.reload();},
          error : function(){alert("Something's wrong.");},
        })
      }

      function add_to_cart(){
         jQuery('#modal_errors').html("");
         var format = jQuery('#format').val();
         var quantity = jQuery('#quantity').val();
         var available = jQuery('#available').val();
         var error = '';
         var data = jQuery('#add_product_form').serialize();
         if(quantity > available){
          error += '<p class="text-danger text-center">There are only '+available+' copies available, contact Admin for higher purchases.</p>';
          jQuery('#modal_errors').html(error);
          return;
         }else if(format == '' || quantity == '' || quantity == 0) {
           error += '<p class="text-danger text-center">You must choose a Format and Quantity.</p>';
           jQuery('#modal_errors').html(error);
           return;
        }
          else {
           jQuery.ajax({
             url : '/CEPA/admin/parsers/add_cart.php',
             method : 'post',
             data : data,
             success : function(){
               location.reload()
             },
             error : function(){alert("Something went wrong");}
           })
         }
      }
    </script>
    </body>
  </html>
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
