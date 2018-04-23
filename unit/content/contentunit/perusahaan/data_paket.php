
		<div class="row" style="padding-top:5px " id="show_our_packet">
			<div class="col-lg-6">
							<table class="table table-sm">
							<thead class="table-secondary">
								<tr>
									<th>Nama</th>
									<th width="60px">#</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$unit = $_SESSION['id_unit'];
							$res=pg_query($dbconn,"Select distinct id_billing_paket from billing_paket_kategori_harga_unit where id_unit='$unit' and id_kategori_harga='$_SESSION[id_perusahaan]' order by id_billing_paket asc");
							while ($row=pg_fetch_assoc($res)) {
								$data=pg_fetch_array(pg_query($dbconn,"Select * from billing_paket where id='".$row["id_billing_paket"]."' "));
							?>
								<tr>
									<td><?php echo $data["nama_paket"] ?></td>
									<td class="text-center">
									   <a href="media.php?content=perusahaan&modul=view_detail_perusahaan&update_paket&id=<?php echo $row['id_billing_paket'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-edit"></i></a>
									   <a href="media.php?content=perusahaan&modul=hapus_paket&id=<?php echo $row['id_billing_paket'] ?>" class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Yakin ingin menghapus data')"><i class="fa fa-trash"></i></a>
									  
									</td>
						
							   
								</tr>
							<?php 
							} 
							?> 
							</tbody>
						</table>
					
            </div>
            
			<div class="col-lg-6 ">
				<div class="card">
				<?php
				if(isset($_GET["update"])){
					include "update_paket.php";

				}
				else{
					include "tambah_paket.php"; 
				}
				?>
			</div>
		</div>
		</div>
     <script>
        $('#tambah_paket').click(function()
        {
        	var id_perusahaan = $('#id_perusahaan').val();
        	var id_billing_paket = $('#id_billing_paket').val();
        	var dis_unit_persen = $('#dis_unit_persen').val();
        	var dis_unit_amt = $('#dis_unit_amt').val();

        	
        	var checkbox1 = []
                  $("input[name='tindakan[]']").each(function ()
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

             var disc_persen_tindakan = []
                  $("input[name='dis_persen_tindakan[]']").each(function ()
                  {
                      if(!$(this).attr("disabled")){
	                      	disc_persen_tindakan.push($(this).val());
	                  }                     
                    

                  });
              var disc_amt_tindakan = []
                  $("input[name='dis_amt_tindakan[]']").each(function ()
                  {
                      if(!$(this).attr("disabled")){
	                      	disc_amt_tindakan.push($(this).val());
	                  } 
                  });

            var checkbox_lab = []
                  $("input[name='lab_analysis[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox_lab.push($(this).val());
                    }
                  });

            var total_lab = []
                  $("input[name='harga_lab[]']").each(function ()
                  {
                      if(!$(this).attr("disabled")){
	                      	total_lab.push($(this).val());
	                  }                     
                    

                  });      

              //alert(total);
    
          $.ajax({
            type: "POST",
            url: "media.php?content=perusahaan&modul=simpan_paket&act=baru",
            data:{  
                    check_tindakan:checkbox1,   
                    total_tindakan:total,
                    check_lab:checkbox_lab,   
                    total_lab:total_lab,
                    id_billing_paket:id_billing_paket,
                    id_perusahaan:id_perusahaan,
                    disc_persen_tindakan:disc_persen_tindakan,
                    disc_amt_tindakan:disc_amt_tindakan,
                    dis_unit_persen:dis_unit_persen,
                    dis_unit_amt:dis_unit_amt


             },
            cache: false,
            success: function(data){
              alert(data);
              //$("#show_our_packet").load("media.php?content=perusahaan");
            }
          });   

        });


       $("#id_billing_paket").change(function(){
		var data=$(this).val();

		$.ajax({
			type 	: 'POST',
			url 	: 'media.php?ajax=view_detail_paket',
			data	: {
				id:data
			},
			success	: function(response){
				$('#paket_detail').html(response);
			}
		});
		});
    </script>