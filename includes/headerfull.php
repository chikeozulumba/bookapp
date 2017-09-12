<script type="text/javascript">
jQuery(function($){
  $('#search-trigger').click(function(){
    $('#search-input').toggleClass('search-input-open');
  });

  $(document).click(function(e){
    if (!$(e.target).closest('.ngen-search-form').length) {
      $('#search-input').removeClass('search-input-open');
    };
  });
});

</script>
<!-- Header -->
<div id="headerWrapper">
  <div id="back-book"></div>
    <div id="logotext">
      <div class="slide-holder">
      <div class="slide-info">
           <h1 style="margin-bottom: 10px; margin-top: 50px; padding-left: 120px;" >
             Large collection of Books & Journals for You.
           </h1>

         <h3 style="margin-right:-200px; font-family: 'Neuton', serif; margin-top: 30px; padding-left: 120px; padding-right: 120px; font-size: 26px">
           CEPA-Bookshop serves as an online retail system for books and other literary materials, ensuring Your books are purchased with ease!
         </h3>
         <div class="form_Q_search">
          <form class="form-search ngen-search-form" action="search.php" method="get">
            <input type="text" name="Search" id="search-input" class="form-search-input search-input" placeholder="Enter Book title"/>
            <span id="search-trigger" class="form-search-submit"> SEARCH &#x1f50e;</span>
          </form>
        </div>
      </div>
    </div>
    </div>

    <br>
  <div class="">

  </div>
<div id="for-book"></div>
</div>
<div class="container-fluid">
<style media="screen">
h1 {
	font-family: 'novecento_sans_widemedium', Arial, Helvetica, sans-serif;
	text-transform: uppercase;
	line-height: 1.2em;
}
.slide-info {
  width: 600px;
  font-size: 14px;
  line-height: 18px;
  display: table-cell;
  height: 685px;
  vertical-align: middle;
  color: #ffffff;
}
.slide-info  h1 {
  font:bold 60px/72px 'novecentosanswide', Arial, Helvetica, sans-serif;
  margin-right: -200px;
  margin-top: -60px;
}
.slide-info h3 {
  margin: 0 0 66px;
  margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
  display: block;
  -webkit-margin-before: 1em;
  -webkit-margin-after: 1em;
  -webkit-margin-start: 0px;
  -webkit-margin-end: 0px;
  list-style: none;
  text-align: -webkit-match-parent;
  list-style-type: disc;
  font-size: 20px;
  font: inherit;
  color:#ffffff;
	font:18px Arial, Helvetica, sans-serif;
}
  #author{
    color: #6e6e6e;
    font: 12px;
    margin-left: 150px;
  }
  #text{
    color: #ffffff;
    font: 20px;
    text-transform: uppercase;
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
  }
  #textsize{
    font-size: 39px;
  }
  .atn {
  	text-transform: uppercase;
  	display: block;
  	text-align: center;
  	border: none;
  	padding: 0;
  	width: 182px;
  	height: 80px;
  	background: #444;
  	color: #fff;
  	font: 18px/40px 'novecento_sans_widemedium', Arial, Helvetica, sans-serif;
  }
  .atn.white {
  	background: #fff;
  	color: #6e6e6e;
    margin-left: 200px;
    display: block;
  }
  .atn.grey {
  	background: #fff;
  	color: #6e6e6e;
  }
  .atn.big {
  	width: 270px;
  	height: 64px;
  	font: 14px/64px 'novecento_sans_widemedium', Arial, Helvetica, sans-serif;
  }
  .atn.normal {
  	width: 182px;
  	height: 40px;
  	font: 14px/40px 'novecento_sans_widemedium', Arial, Helvetica, sans-serif;
  }
  .atn-delete:hover,
  .atn:hover {
  	text-decoration: none;
  	opacity: 0.9;
  }
  .atn-delete {
  	width: 40px;
  	height: 40px;
  	background: url(../images/btn_delete.gif) no-repeat;
  	overflow: hidden;
  	text-indent: -9999px;
  	display: block;
  }
  .atn.black {
  	background: #444;
  	color: #fff;
  }
  .atn-delete {
		background: url(../images/btn_delete@x2.gif) no-repeat;
		background-size:40px 40px;
	}
</style>
