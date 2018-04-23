        <div class="row" style="padding-top:5px " id="data_tindakan">
			<div class="col-lg-6">
						<table id="myTable22" class="table table-sm">
							<thead class="table-secondary">
								<tr>
									<th>Kode</th>
									<th>Nama</th>
									<th>Harga</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
							$unit = $_SESSION['id_units'];
							$res=pg_query($dbconn,"Select id, id_tindakan, harga from tindakan_kategori_harga_unit where id_unit='$unit' and id_kategori_harga='$_SESSION[id_perusahaan]' order by id_tindakan asc");

							while ($row=pg_fetch_assoc($res)) {
								$data=pg_fetch_array(pg_query($dbconn,"Select * from tindakan where id='".$row["id_tindakan"]."' "));
								 ?>
								<tr>
									<td style="vertical-align:middle;"><?php echo $data["kode"] ?></td>
									<td style="vertical-align:middle;"><?php echo $data["nama"] ?></td> 
									<td style="vertical-align:middle;"><?php echo number_format($row["harga"],'0','','.') ?></td>                       
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
        $('#btnTambahTindakan').click(function()
        {
        	var id_perusahaan = $('#id_perusahaan').val();
        	var checkbox1 = []
                  $("input[name='id_tindakan[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox1.push($(this).val());
                    }
                  });

            var total = []
                  $("input[name='harga_tindakan[]']").each(function ()
                  {
                      if(!$(this).attr("disabled")){
	                      	total.push($(this).val());
	                  }                     
                    

                  });   

	         $.ajax({
	            type: "POST",
	            url: "media.php?perusahaan=simpan_tindakan&act=baru",
	            data:{  
	                    check:checkbox1,   
	                    total:total,
	                    id_perusahaan:id_perusahaan
	             },
	            success: function(data){
	              $("#nonlab").load("media.php?perusahaan=data_tindakan");
	            }
	          });   

        });

        $('.btnHapus').click(function()
        {
        	 if (confirm('Apakah Anda Ingin Menghapus?')) {
        	 	var data = $(this).attr('id'); 
		       
		       	$.ajax({  
		            type: "POST",
		            url: 'media.php?perusahaan=simpan_tindakan&act=delete',
		            data: {id:data},
		            success: function () {
		                $("#nonlab").load("media.php?perusahaan=data_tindakan");
		            }
		        });
   			 }
		    
		});

		$('.btnUpdateTindakan').click(function(){
          var data = $(this).attr('id');
         
           $("#nonlab").load("media.php?perusahaan=data_tindakan&update&id="+data);
       
        });

         $('#kembali_tindakan').click(function(){

           $("#nonlab").load("media.php?perusahaan=data_tindakan");

        
        });

          $('#btnSimpanEditTindakan').click(function(){

            var data = $("#form_edit_tindakan").serialize(); 
            $.ajax({  
                type: "POST",
                url: 'media.php?perusahaan=simpan_tindakan&act=edit',
                data: data,
                success: function () {
                    $("#nonlab").load("media.php?perusahaan=data_tindakan");
                }
            });

        });

          $(document).ready(function(){
          $('#myTable11').DataTable({
            "oLanguage": {
              "sSearch": "Cari : ",
              "sLengthMenu": "Tampilkan _MENU_ records",
            }});
          $('#myTable22').DataTable({
            "oLanguage": {
              "sSearch": "Cari : ",
              "sLengthMenu": "Tampilkan _MENU_ records",
            }});
        });
    </script>