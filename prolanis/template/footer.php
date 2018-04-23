<footer class="main-footer">
    <div class="pull-right hidden-xs">
     
    </div>
    <strong>Copyright &copy; 2017 <a href="media.php">PT. Kimia Farma Diagnostika</a>.</strong> All rights
    reserved. 
  </footer>

 
</div>
<!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script src="assets/plugins/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="assets/dist/js/pages/dashboard.js"></script>
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script src="assets/dist/js/demo.js"></script>

<script src="assets/bootstrap/js/bootstrap-datepicker.js"></script>
<script src="assets/bootstrap/js/bootstrap-toggle.min.js"></script>
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script src="assets/dist/js/readurl.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>

<script>

    $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    });

      $( function() {
        $( "#datepicker" ).datepicker({ format: 'yyyy-mm-dd' });
    	//alert('woi');
        
      } );
      $( function() {
        $( "#datepicker3" ).datepicker({ format: 'yyyy-mm-dd' });
    	//alert('woi');
        
      } );

        $( function() {
        $( "#datepicker2" ).datepicker({ 
            format: 'yyyy-mm-dd',
            minDate: 0, });
      } );

    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else{
            $(':checkbox').each(function() {
                this.checked = false;                        
            });
        }
    });
    $('#select-all2').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else{
            $(':checkbox').each(function() {
                this.checked = false;                        
            });
        }
    });

      $(function () {
        $("#example1").DataTable(
         {
          "language": {
            "search": "Cari:",
            "sLengthMenu": "Tampilkan _MENU_ records",
             "info": "Menampilkan _START_ ke _END_ dari total _TOTAL_"
          }
        }
          );
        $("#example3").DataTable();
        $("#example4").DataTable();
        $("#example5").DataTable();
        $("#example6").DataTable();
        $("#example7").DataTable();
        $("#example8").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
            
                      /*disable checkbox harga inventori*/
      			$("#example1 td [type=checkbox]").click(function() {
                          
      			 var next = $(this).closest('tr').find('td input[type=text]:first');
      			 next.attr("disabled", !this.checked);
      					//next.val("00");
      				  //alert("noob");
      			});

      			$('select[name=metode_harga]').on('change', function() {
      			  var metode =this.value ;
      			  if(metode=='S'){				  
      				  $('#uang input').attr("placeholder", "Rp");
      			  }else{
      				  $('#uang input').attr("placeholder", "%");
      			  }
      			  
      			})


            /*aktif treeview*/
            var res = window.location;
            var n = $.trim(res).includes("&");
            if(n=true){
              var url = $.trim(res).split("&", 1);
              //alert("betul");
            }
           else{
              var url = res;
            }
            // for sidebar menu entirely but not cover treeview
            $('ul.sidebar-menu a').filter(function() {
              return this.href == url;
            }).parent().addClass('active');

            // for treeview
            $('ul.treeview-menu a').filter(function() {
              return this.href == url;
            }).closest('.treeview').addClass('active');
                


</script>


</body>
</html>