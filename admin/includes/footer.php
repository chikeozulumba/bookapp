
</div>
</div>
</div>
</div>
<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->
</div>

<!--footer-->
<!-- <footer class=" col-md-12 text-center" id="footer">&copy; Copyright 2009 - 2016
  <a style="font-family: 'Trirong', serif;" href="https://www.cepajournal.com/">CepaJournal</a></footer>

maybe 2 closing divs should be here in case of error--> 
 <!-- jQuery -->
 <script src="js/jquery.js"></script>

 <!-- Bootstrap Core JavaScript -->
 <script src="js/bootstrap.min.js"></script>

 <!-- Menu Toggle Script -->
 <script>
 $("#menu-toggle").click(function(e) {
 e.preventDefault();
 $("#wrapper").toggleClass("toggled");
 });
 </script>

 <script>
 function authormodal(id){
   var data = {'id' : id};
   jQuery.ajax({
     url : '/CEPA/admin/includes/authormodal.php',
     method : "post",
     data : data,
     success : function(data){
       jQuery('body').append(data);
       jQuery('#author').modal('toggle');
     },
     error : function(){
       alert("something's wrong")
     }
   });
 }
 function msgmodal(id){
   var data = {'id' : id};
   jQuery.ajax({
     url : '/CEPA/admin/includes/msgmodal.php',
     method : "post",
     data : data,
     success : function(data){
       jQuery('body').append(data);
       jQuery('#message').modal('toggle');
     },
     error : function(){
       alert("something's wrong")
     }
   });
 }

 function updateformat(){
   var format_String = '';
   for (var i = 1; i <= 12; i++) {
    if (jQuery('#format'+ i).val() != '') {
      format_String += jQuery('#format' + i).val()+':'+jQuery('#qty'+ i).val()+':'+jQuery('#threshold' + i).val()+',';
    }
   }
   jQuery('#formats').val(format_String);
 }
  function get_child_options(selected){
    if (typeof selected === 'undefined') {
      var selected = '';
    }
    var parentID = jQuery('#parent').val();
    jQuery.ajax({
      url: '/CEPA/admin/parsers/child_categories.php',
      type: 'POST',
      data: {parentID : parentID, selected: selected},
      success: function(data){
        jQuery('#child').html(data);
      },
      error: function(){alert("Something went wrong with child options.")},
    });
  }
  jQuery('select[name="parent"]').change(function(){
    get_child_options();
  });
 </script>
    </body>
  </html>
