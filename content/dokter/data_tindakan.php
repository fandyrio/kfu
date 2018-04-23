        <div class="row" style="padding-top:5px " id="data_tindakan">
        <input type="hidden" id="poly" value="<?php echo $_GET[poly_id] ?>">
			<div class="col-lg-6">
				<table id="myTable13" class="table table-sm">
					<thead class="table-secondary">
								<tr>
									<th>Kode</th>
									<th>Tindakan</th>
									<th>Harga</th>
									<th>Persen Dokter</th>
									<th>Persen Perawat</th>
									<th></th>
								</tr>
					</thead>
					<tbody>
							<?php
							session_start();
							include "../../config/conn.php";

							$unit = $_SESSION['id_units'];
							$res=pg_query($dbconn,"Select id, id_tindakan, harga, persen_dokter, persen_perawat from tindakan_dokter_unit where id_unit='$unit' and id_karyawan='$_SESSION[id_dokter]' order by id_tindakan asc");

							

							while ($row=pg_fetch_assoc($res)) {
								$data=pg_fetch_array(pg_query($dbconn,"Select * from tindakan where id='".$row["id_tindakan"]."' "));
								 ?>
								<tr>
									<td style="vertical-align:middle;"><?php echo $data["kode"] ?></td>
									<td style="vertical-align:middle;"><?php echo $data["nama"] ?></td> 
									<td style="vertical-align:middle;"><?php echo number_format($row["harga"],'0','','.') ?></td> 
									<td style="vertical-align:middle;"><?php echo $row["persen_dokter"] ?></td> 
									<td style="vertical-align:middle;"><?php echo $row["persen_perawat"] ?></td>                       
									<td class="text-center" style="vertical-align:middle;">
										<a id="<?php echo $row['id']?>" class="btn btn-success btn-xs btn-flat btnUpdateTindakan"><i class="fa fa-edit"></i></a>
										<a id="<?php echo $row['id'] ?>" class="btn btn-danger btn-xs btn-flat btnHapus"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							 <?php 
							 } 
							 ?> 
					</tbody>
				</table>
			</div>

			<div class="col-lg-6">
				<?php
					if(isset($_GET["update"])){
						include "update_tindakan.php";

					}
					else{
					 include "tambah_tindakan.php"; 
					}
				?>
			</div>
		</div>


		<script>

		 $(".example1 td [type=checkbox]").click(function() {
                          
                 var next = $(this).closest('tr').find('td input[type=text]');
                 next.attr("disabled", !this.checked);
                });

        $('#btnTambahTindakan').click(function()
        {
        	var poly = $('#poly').val();
        	var checkbox1 = []
                  $("input[name='id_tindakan[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox1.push($(this).val());
                    }
                  });

            var total = []
                  $("input[name='persen_dokter[]']").each(function ()
                  {
                      if(!$(this).attr("disabled")){
	                      	total.push($(this).val());
	                  }                     
                    

                  }); 

            var total2 = []
                  $("input[name='persen_perawat[]']").each(function ()
                  {
                      if(!$(this).attr("disabled")){
	                      	total2.push($(this).val());
	                  }                     
                    

                  });       

            var harga_unit = []
                  $("input[name='harga[]']").each(function ()
                  {
                      if(!$(this).attr("disabled")){
	                      	harga_unit.push($(this).val());
	                  }                     
                    

                  });   

	         $.ajax({
	            type: "POST",
	            url: "content/dokter/simpan_tindakan.php?act=baru",
	            data:{  
	                    check:checkbox1,   
	                    persen_dokter:total,
	                    persen_perawat:total2,
	                    poly:poly,
	                    harga:harga_unit
	             },
	            success: function(data){

	              	$("#nonlab").load("content/dokter/data_tindakan.php?poly_id="+poly);
	            }
	          });   

        });

        $('.btnHapus').click(function()
        {
        	 if (confirm('Apakah Anda Ingin Menghapus?')) {
        	 	var data = $(this).attr('id');
        	 	var poly = $('#poly').val(); 		       
		       	$.ajax({  
		            type: "POST",
		            url: 'content/dokter/simpan_tindakan.php?act=delete',
		            data: {id:data},
		            success: function () {
		                $("#nonlab").load("content/dokter/data_tindakan.php?poly_id="+poly);
		            }
		        });
   			 }
		    
		});

		$('.btnUpdateTindakan').click(function(){
          var data = $(this).attr('id');
          var poly = $('#poly').val();
           $("#nonlab").load("content/dokter/data_tindakan.php?update&id="+data+"&poly_id="+poly);
       
        });

         $('#kembali_tindakan').click(function(){

           $("#nonlab").load("content/dokter/data_tindakan.php");

        
        });

          $('#btnSimpanEditTindakan').click(function(){

          	var poly = $('#poly').val();
            var data = $("#form_edit_tindakan").serialize(); 
            $.ajax({  
                type: "POST",
                url: 'content/dokter/simpan_tindakan.php?act=edit',
                data: data,
                success: function (data) {
                	//alert(data);
                    $("#nonlab").load("content/dokter/data_tindakan.php?poly_id="+poly);
                }
            });

        });

          $(document).ready(function(){
          $('#myTable11').DataTable({
            "oLanguage": {
              "sSearch": "Cari : ",
              "sLengthMenu": "Tampilkan _MENU_ records",
            }});
          $('#myTable13').DataTable({
            "oLanguage": {
              "sSearch": "Cari : ",
              "sLengthMenu": "Tampilkan _MENU_ records",
            }});
        });
    </script>