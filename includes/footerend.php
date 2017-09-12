<!--footer-->
<footer class="text-center" id="footer">&copy; Copyright 2009 - 2016
  <a style="font-family: 'Trirong', serif;" href="https://www.cepajournal.com/">CepaJournal </a><a class="btn btn-danger btn-xs" href="admin/index.php">Site Admin</a></footer>


        </div>
      </div>
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
      </style>
    <script>
      jQuery(window).scroll(function(){
        var vscroll = jQuery(this).scrollTop();
        jQuery('#logotext').css({
          "transform" : "translate(0px, "+vscroll/2+"px)"
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

    </script>
    </body>
  </html>
