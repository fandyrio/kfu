<footer class="main-footer">
    <div class="pull-right hidden-xs">
     
    </div>
    <strong>Copyright &copy; 2017 <a href="media.php">MIT Care Medan</a>.</strong> All rights
    reserved.
  </footer>

 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->

</div>
<!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script src="assets/plugins/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="assets/plugins/raphael/raphael.min.js"></script>
<script src="assets/"plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="assets/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="assets/plugins/moment/moment.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets/dist/js/pages/dashboard.js"></script>
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>

<script src="assets/bootstrap/js/bootstrap-datepicker.js"></script>
<script src="assets/bootstrap/js/bootstrap-toggle.min.js"></script>

<script src="assets/plugins/select2/select2.full.min.js"></script>


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
        $( "#datepicker2" ).datepicker();
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
        $("#example1").DataTable();
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

		/***PENAWARAN HARGA */
          /*simpan quotation ln*/
      			$('body').on('click', '#simpan_q_ln', function (){
      				 var data = $("#quo").serialize();
      				// alert(data);
      			 $.ajax({
      			   type:'post',
      			   url :"media.php?ajax=save_q_ln",
      			   data:data,
      			   success: function(data) {
                alert(data);
      					$("#quotation").load("media.php?ajax=quotation");
      					//alert(data);
                //window.location.href = 'media.php?ajax=quotation';

      			   },
      			   error:function(exception){alert('Exeption:'+exception);}
      			   })
      			   
      			});
			/*simpan quotation header*/
      			$('body').on('click', '#penawaran_harga_save', function (){
      				 var data = $("#form_penawaran").serialize();
      				 //alert(data);
      			 $.ajax({
      			   type:'post',
      			   url :"media.php?ajax=save_q_hdr",
      			   data:data,
      			   success: function(data) {
      					//$("#quotation").load("media.php?ajax=quotation");
      					alert(" nilai form"+data);


      			   },
      			   error:function(exception){alert('Exeption:'+exception);}
      			   })
      			   
      			});

				/*HAPUS quotation ln*/
      			$('body').on('click', '.hapus_quotation', function (){
      				 var data = $(this).attr('id');
      				//alert(data);

      			 $.ajax({
              
               type:'post',
               url :"media.php?ajax=hapus_q_ln&id="+data,
               data:data,
               success: function(data) {
                $("#quotation").load("media.php?ajax=quotation");
                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
      			   
      			});
				
				/*****************************************************8*/

        /*PURCHASE ORDER*/
        /*ajax fomr po ln*/
            $('body').on('click', '#add_po', function (){
                var ajax_load = "";
                $("#purchase_order").html(ajax_load).load("media.php?ajax=add_po_ln");
      
            });

        ///////////////////////////////////////////////////////////////////////////////

            /*ajax rq*/
            $('body').on('click', '#add_rq', function (){
                var ajax_load = "";
                $("#result").html(ajax_load).load("media.php?ajax=add_rq_ln");
      
            });
            $('body').on('click', '#cancel_rq', function (){
                var ajax_load = "";
                $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
      
            });
            /*simpan RQ_LN*/
            $('body').on('click', '#simpan_rq_ln', function (){
                 var data = $("#rquo").serialize();
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_rq_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert("sukses");
                    $("#result").load("media.php?ajax=rq_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

                /*simpan edit RQ_LN*/
            $('body').on('click', '#simpan_edit_rq_ln', function (){
                 var data = $("#edit_rquo").serialize();
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_edit_rq_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert("sukses");
                    $("#result").load("media.php?ajax=rq_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

              /*simpan RQ_HDR*/
            $('body').on('click', '#simpan_rq_hdr', function (){
                 var data = $("#rquohdr").serialize();
                 //alert(data);
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_rq_hdr",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert(data);
                    window.location.href = 'media.php?inventori=rq';

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

            /*HAPUS request quotation ln*/
            $('body').on('click', '.hapus_rq', function (){
               var data = $(this).attr('id');
              //alert(data);
             $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_rq_ln&id="+data,
               data:data,
               success: function(data) {
                $("#result").load("media.php?ajax=rq_ln");
                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
               
            });

            /*Edit request quotation ln*/
            $('body').on('click', '.edit_rq', function (){
               var data = $(this).attr('id');
     
                $("#result").load("media.php?ajax=edit_rq_ln&id="+data);
       
            });

            ///////////////////////
			
    			$('body').on('click', '#add_q', function (){
    				var ajax_load = "";
    				$("#quotation").html(ajax_load).load("media.php?ajax=q_ln");
    
    			});
    			$('body').on('click', '#cancel_q', function (){
    				var ajax_load = "";
    				$("#quotation").html(ajax_load).load("media.php?ajax=quotation");
   
    			});

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
                $("#cancel_rq_hdr").click(function(){
                    window.location.href = 'media.php?inventori=rq';
                });
                 $("#cancel_q_hdr").click(function(){
                    window.location.href = 'media.php?inventori=quotation';
                });

                 $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
				         $("#quotation").html(ajax_load).load("media.php?ajax=quotation");
                 $("#purchase_order").html(ajax_load).load("media.php?ajax=po_ln");
            // end  
            });

</script>

</body>
</html>