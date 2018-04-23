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
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<!-- <script src="assets/plugins/raphael/raphael.min.js"></script>
<script src="assets/plugins/morris/morris.min.js"></script> -->
<!-- Sparkline --><!-- 
<script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script> -->
<!-- jvectormap -->
<!-- <script src="assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="assets/plugins/knob/jquery.knob.js"></script> -->
<!-- daterangepicker -->
<!-- <script src="assets/plugins/moment/moment.js"></script>
 --><!-- Bootstrap WYSIHTML5 -->
<!-- <script src="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets/dist/js/pages/dashboard.js"></script>
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- <script src="assets/plugins/datatables/range_dates.js"></script> -->
<!-- SlimScroll -->
<!-- <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script> -->
<!-- FastClick -->
<!-- <script src="assets/plugins/fastclick/fastclick.js"></script> -->

<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>

<script src="assets/bootstrap/js/bootstrap-datepicker.js"></script>
<script src="assets/bootstrap/js/bootstrap-toggle.min.js"></script>

<script src="assets/plugins/select2/select2.full.min.js"></script>
<script src="assets/dist/js/readurl.js"></script>

<!-- purchase order js -->
<!-- <script src="assets/js/action/purchase_order.js"></script> -->
<!-- reguest quotation js -->
<!-- <script src="assets/js/action/rq.js"></script> -->
<!-- js -->
<!-- <script src="assets/js/action/quo.js"></script>
<script src="assets/js/action/grn.js"></script>
<script src="assets/js/action/retur.js"></script>
<script src="assets/js/action/buka_stok.js"></script>
<script src="assets/js/action/stok_penyesuaian.js"></script>
<script src="assets/js/action/stok_transfer.js"></script>
<script src="assets/js/action/stok_bergerak.js"></script>
<script src="assets/js/action/stok_adj.js"></script>
<script src="assets/js/action/stok_saat_ini.js"></script> -->
<script src="assets/js/action/lab_analisis_range.js"></script>
<script src="assets/js/action/tindakan.js"></script> 
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>

<!-- page script -->
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
        $( "#datepicker2" ).datepicker({ format: 'yyyy-mm-dd' });
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



      $('#select-tambah').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.tambah').each(function() {
                this.checked = true;                        
            });
        } else{
            $('.tambah').each(function() {
                this.checked = false;                        
            });
        }
    });

      $('#select-edit').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.edit').each(function() {
                this.checked = true;                        
            });
        } else{
            $('.edit').each(function() {
                this.checked = false;                        
            });
        }
    });

      $('#select-hapus').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.hapus').each(function() {
                this.checked = true;                        
            });
        } else{
            $('.hapus').each(function() {
                this.checked = false;                        
            });
        }
    });


      $('#select-lihat').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.lihat').each(function() {
                this.checked = true;                        
            });
        } else{
            $('.lihat').each(function() {
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
            
      //datatable icd 10
       $(document).ready(function() {
                var dataTable = $('#lookup').DataTable( {
                  "language": {
                    "search": "Cari:",
                    "sLengthMenu": "Tampilkan _MENU_ records",
                     "info": "Menampilkan _START_ ke _END_ dari total _TOTAL_"

                        },
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                        url :"assets/ajax/ajax-grid-data.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                            $(".lookup-error").html("");
                            $("#lookup").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#lookup_processing").css("display","none");
                            
                        }
                    }
                } );
            } );

            //datatable diagnosis folder
              $(document).ready(function() {
                var dataTable = $('#diagnosis').DataTable( {
                   "language": {
                    "search": "Cari:",
                    "sLengthMenu": "Tampilkan _MENU_ records",
                     "info": "Menampilkan _START_ ke _END_ dari total _TOTAL_"

                        },
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                        url :"assets/ajax/ajax-grid-data_diagnosis.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                            $(".diagnosis-error").html("");
                            $("#diagnosis").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#diagnosis_processing").css("display","none");
                            
                        }
                    }
                } );
            } );

               //preview image
              function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah')
                            .attr('src', e.target.result)
                            .width(150)
                            .height(200);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }


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

            $(function(){
                // don't cache ajax or content won't be fresh
                $.ajaxSetup ({
                    cache: false
                });
                var ajax_load = "";
                
                // load() functions
                $("#rq").click(function(){
                    $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
                });

                 $("#add_rq").click(function(){
                    $("#result").html(ajax_load).load("media.php?ajax=add_rq_ln");
					//alert("woi");
                });
				// $("#quotation").html(ajax_load).load("media.php?ajax=q_ln");
               
                $("#cancel_rq").click(function(){
                    $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
                });
				        $("#cancel_q").click(function(){
                    $("#quotation").html(ajax_load).load("media.php?ajax=quotation");
                });

                 $("#stok_gerak").html(ajax_load).load("media.php?ajax=stok_bergerak");
                 $("#update_p_ln").html(ajax_load).load("media.php?ajax=update_po_ln"); 
                 $("#update_q_ln").html(ajax_load).load("media.php?ajax=update_q_ln"); 
                 $("#update_ln").html(ajax_load).load("media.php?ajax=update_rq_ln");
                 $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
				         $("#quotation").html(ajax_load).load("media.php?ajax=quotation");
                 $("#purchase_order").html(ajax_load).load("media.php?ajax=po_ln");

                
            });

             /* $(".treeview").on("click", function() {
                $(".treeview").removeClass("active");
                $(this).addClass("active");
              }); */

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

<script>
	$("#id_provinsi").change(function(){

		var id_provinsi=$(this).val();
    
		$.ajax({
			type 	: 'POST',
			url 	: 'data/kabupaten.php',
			data	: {id_provinsi:id_provinsi},
			success	: function(response){
 
				$('#id_kabupaten').html(response);
			}
		});
	});
	
	$("#id_kabupaten").change(function(){
		var id_kabupaten=$(this).val();
		$.ajax({
			type 	: 'POST',
			url 	: 'data/kecamatan.php',
			data	: 'id_kabupaten='+id_kabupaten,
			success	: function(response){
				$('#id_kecamatan').html(response);
			}
		});
	});
	
	$("#id_kecamatan").change(function(){
		var id_kecamatan=$(this).val();
		$.ajax({
			type 	: 'POST',
			url 	: 'data/kelurahan.php',
			data	: 'id_kecamatan='+id_kecamatan,
			success	: function(response){
				$('#id_kelurahan').html(response);

			}
		});
	});


$("#inventori_nama").change(function(){
    var brand=$(this).val();
    $.ajax({
      type  : 'POST',
      url   : 'media.php?ajax=cek',
      data  : 'brand='+brand,
      success : function(response){
        alert(response);

      }
    });
  });
  
    

</script>

</body>
</html>