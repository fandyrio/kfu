
	 <div class="row" style="padding-top:5px ">
		<div class="col-lg-6">
			
					<table id="myTable23" class="table table-sm">
						<thead class="table-secondary">
							<tr>
								<th>Kode</th>
								<th >Nama</th>
								<th >Harga(Rp)</th>
								<th >#</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$id_unit= $_SESSION['id_units'];
						$res=pg_query($dbconn,"Select id, id_lab_analysis_group, harga_unit from lab_analysis_group_unit WHERE id_unit='$id_unit' and id_kategori_harga='$_SESSION[id_perusahaan]' order by id asc");
						while ($row=pg_fetch_assoc($res)) {
							$view=pg_fetch_assoc(pg_query($dbconn,"Select * from lab_analysis_group WHERE id='$row[id_lab_analysis_group]'"));
						?>
							<tr>
								<td><?php echo $view["kode"] ?></td>
								<td><?php echo $view["nama"] ?></td>
								<td><?php echo number_format($row["harga_unit"],'0','','.') ?></td>
								<td class="text-center">
								   <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs btn-flat btnEditMulti"><i class="fa fa-edit"></i></a>
								   <a id="<?php echo $row['id_lab_analysis_group']?>" class="btn btn-success btn-xs btn-flat btnViewMulti"><i class="fa fa-eye"></i></a>
								   <a id="<?php echo $row['id'] ?>" class="btn btn-danger btn-xs btn-flat btnHapusMulti" ><i class="fa fa-trash"></i></a>
								  
								</td>
							</tr>
						<?php 
						} 
						?> 
						</tbody>
					</table>
			
		</div>
		<div class="col-lg-6">
			<div class="card">
			<?php
				if(isset($_GET["view"])){
					include "view_multitest.php";

				}elseif(isset($_GET["edit"])){
					include "edit_multitest.php";

				}
				else{
				 include "tambah_multitest.php"; 
				}
			?>
			</div>
		</div>
    </div>

    <script>
        $('#btnTambahMulti').click(function()
        {
          var checkbox1 = []
                  $("input[name='id_multi[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox1.push($(this).val());
                    }
                  });

            var total = []
                  $("input[name='harga_multi[]']").each(function ()
                  {
                       if(!$(this).attr("disabled")){
                          total.push($(this).val());
                      }  
                  });
            
            $.ajax({
              type: "POST",
              url: "media.php?perusahaan=simpan_multitest&act=baru",
              data:{  
                      multi:checkbox1,   
                      total:total
               },
              success: function(data){
        
                $("#multiple").load("media.php?perusahaan=data_multitest");
              }
            });

            return false;
        });

        $('.btnHapusMulti').click(function(){

           if (confirm('Apakah Anda Ingin Menghapus?')) {
            var data = $(this).attr('id'); 
           
            $.ajax({  
                type: "POST",
                url: 'media.php?perusahaan=simpan_multitest&act=delete',
                data: {id:data},
                success: function () {
                    $("#multiple").load("media.php?perusahaan=data_multitest");
                }
            });
         }
        
        });


        $('.btnEditMulti').click(function(){
          var data = $(this).attr('id'); 

           $("#multiple").load("media.php?perusahaan=data_multitest&edit&id="+data);

        
        });

         $('.btnViewMulti').click(function(){
          var data = $(this).attr('id');
         
           $("#multiple").load("media.php?perusahaan=data_multitest&view&id="+data);
       
        });

          $('#btnSimpanEditMulti').click(function(){

            var data = $("#form_edit_multi").serialize(); 
            $.ajax({  
                type: "POST",
                url: 'media.php?perusahaan=simpan_multitest&act=edit',
                data: data,
                success: function () {          
                    $("#multiple").load("media.php?perusahaan=data_multitest");
                }
            });

        });

         $(document).ready(function(){
          $('#myTable10').DataTable({
            "oLanguage": {
              "sSearch": "Cari : ",
              "sLengthMenu": "Tampilkan _MENU_ records",
            }});
          
           $('#myTable23').DataTable({
            "oLanguage": {
              "sSearch": "Cari : ",
              "sLengthMenu": "Tampilkan _MENU_ records",
            }});
        });

        </script>