<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";


 $id_pasien=$_POST['id_pasien'];
 $id_kunjungan=$_POST['id_kunjungan'];
 $id_kategori_harga=$_POST["id_kategori_harga"];

?>
<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
<input type="hidden" id="id_kategori_harga" value="<?php echo $id_kategori_harga;?>">
<input type="hidden" name="no_rm" value="<?php echo $_POST[no_rm];?>" id="no_rm">
		<div class="card">
			<div class="card-header">
				<strong>Catat Resep</strong>
			</div>
			<div class="card-block">
				<div class="row">
				
					
					<div class="col-md-7">
						<fieldset>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Kategori Layanan </label>
								<div class="col-md-8">
									<select name="id_layanan" id="id_layanan" class="form-control" >
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM master_unit_perusahaan where id_unit='$_SESSION[id_units]' ");
										while($r=pg_fetch_array($tampil)){
											$goar=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_kategori_harga where id='$r[id_perusahaan]' "));
											echo"<option value='$goar[id]'>$goar[nama]</option>";
										}
										?>
									</select>
								</div>
							</div>
							
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkiri1" role="tab" aria-controls="tabkiri1">Obat</a>
                                </li>
                            </ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tabkiri1" role="tabpanel">
									<br>
							
									<div class="form-group data-lab" id="data_obat">
									</div>
								</div>
										<br>
						
								
					
							</div>
							
						</fieldset>
					</div>
					
					<div class="col-md-5">
					
							<fieldset>
							<div id="pasien_detail_resep">
							
							</div>
							</fieldset>
							<fieldset>
						
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkanan1" role="tab" aria-controls="tabkanan1">Detail</a>
                                </li>
                                
                            </ul>
							<div id="detail_catat_resep">
							<div class="tab-content">
								<div class="tab-pane active" id="tabkanan1" role="tabpanel">
									<br>
									BELUM ADA RESEP TERPILIH
									
								</div>
							</div>
							</div>
						</fieldset>
					</div>
					
					<div class="col-md-12">
						<button type="button" class="btn btn-primary btn-sm" id="btnSimpanResep">Simpan</button>
					</div>
				</div>
			</div>
		</div>


	
		<link href="assets/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/datatable_code.js"></script>
		<script type="text/javascript">	


		$(document).ready(function() {
		 	 $('#data_obat').load("content/pasien/catatresep/data_obat.php?id_pasien="+<?php echo $id_kategori_harga?>);
		 	
		 	 $("#pasien_detail_resep").load("content/pasien/catatresep/nama_obat.php?id_pasien="+<?php echo $id_pasien?>+"&id_kunjungan="+<?php echo $id_kunjungan?>+"&id_kategori_harga="+<?php echo $id_kategori_harga?>);		 	
            });

		 /**/
		 $('#id_layanan').change(function(){
		 	var id_kategori = $('#id_layanan').val();
		 	$('#data_obat').load("content/pasien/catatresep/data_obat.php?id_pasien="+id_kategori);

		 });

		$('#btnSimpanResep').click(function(){
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var no_rm= $("#no_rm").val();
			var dokter=$("#dokter").val();
			var data= 'id='+no_rm+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&dokter='+dokter+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
			
			$.ajax({
				type: "POST",
				url: "aksi-catat-resep",
				data: data,
				success: function(data){
					$("#data_pasien").load("catat-resep1-"+no_rm+"-"+id_kunjungan);
				}
			});
			
		});

		//load batch 
		$('body').on('click', '.resep_loader tr', function (){
                var id= $(this).attr('id'); 

                           
                if(id){
                   
                     $.ajax({
                      url: 'content/pasien/catatresep/detail_resep.php',
                      type: 'POST',
                      data: {id:id},
                      success: function (data) {
                          $('#tabkanan1').html(data);
                         // $('#tabkanan2').load("content/pasien/catatresep/detail_batch.php?id="+id);
                      }
                    
                      });
                  }

            });

		$("#data_obat").on("click",".btnTambahPesancatatResep", function(){
 			 var id=$(this).attr('id_k');
 			 //alert(id);
				var id_departemen= $("#id_departemen").val();
				var id_layanan= $("#id_layanan").val();
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var data= 'id_inv='+id+'&id_departemen='+id_departemen+'&id_layanan='+id_layanan+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
				//alert(id);

				/*$.ajax(
				{
					type:"POST",
					url:"content/pasien/catatresep/cek_stok.php",
					data:{id:id},
					success:function(result)
					{
						var resultObj=JSON.parse(result);
						var stokObat=resultObj.stock;
						if(stokObat > 0)
						{*/
							$.ajax({
							type: "POST",
							url: "aksi-tambah-catat-resep",
							data: data,
							success: function(data)
							{
								$("#pasien_detail_resep").load("content/pasien/catatresep/nama_obat.php?id_pasien="+id_pasien+"&id_kunjungan="+id_kunjungan+"&id_kategori_harga="+id_layanan);
							}
							});
					/*	}
						else
						{
							alert("Stok kosong");
						}
					}
				});*/

			
			});

		
		 
		 /**/

		 $("#data_obat").on('click', '.btnTambahPesancatatRacik', function (){
				var id=$(this).attr('id_k');
				var id_departemen= $("#id_departemen").val();
				var id_layanan= $("#id_layanan").val();
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var data= 'id_inv='+id+'&id_departemen='+id_departemen+'&id_layanan='+id_layanan+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
				

				$.ajax({
					type: "POST",
					url: "content/pasien/catatresep/aksi_racikkan.php",
					data: data,
					success: function(data){
						
						$("#pasien_detail_resep").load("content/pasien/catatresep/nama_obat.php?id_pasien="+id_pasien+"&id_kunjungan="+id_kunjungan+"&id_kategori_harga="+id_layanan);
					}
				});
			
		});
		/**/


		$('#pasien_detail_resep').on('click', '.btnHapusItemResep', function (){
			var id=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
					

			$.ajax({
				type: "POST",
				url: "aksi-hapus-catat-resep",
				data: dataString2,
				success: function(data){
					
					$("#pasien_detail_resep").load("content/pasien/catatresep/nama_obat.php?id_pasien="+id_pasien+"&id_kunjungan="+id_kunjungan+"&id_kategori_harga="+<?php echo $id_kategori_harga ?>);
				}
			});
			
		});

		$('#pasien_detail_resep').on('click', '.btnHapusItemRacik', function (e){
			var id=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;

			alert(id_pasien);

		
			$.ajax({
				type: "POST",
				url: "content/pasien/catatresep/hapus_racik.php",
				data: dataString2,
				success: function(data){
					
					$("#pasien_detail_resep").load("content/pasien/catatresep/nama_obat.php?id_pasien="+id_pasien+"&id_kunjungan="+id_kunjungan+"&id_kategori_harga="+<?php echo $id_kategori_harga?>);

					
				}
			});
			
		});


		$('#detail_catat_resep').on('click', '#btnUpdateResep', function (){
            var data = $("#form_resep").serialize();
            var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val(); 
                  $.ajax({
                      url: 'content/pasien/catatresep/update_resep.php',
                      type: 'POST',
                      data: data,
                      success: function (data) {
                      	$("#pasien_detail_resep").load("content/pasien/catatresep/nama_obat.php?id_pasien="+id_pasien+"&id_kunjungan="+id_kunjungan+"&id_kategori_harga="+<?php echo $id_kategori_harga?>);

                      	$("#detail_catat_resep").hide();
                      	
                      	 alert("BERHASIL DIUPDATE");

                      }
                    
                      });
                  

            });


		$('#pasien_detail_resep').on('click', '#btnSimpanRacik', function (){
			var data = $("#racikan").serialize(); 
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();

			$.ajax({
				type: "POST",
				url: "content/pasien/catatresep/save_racikan.php",
				data: data,
				success: function(data){
					
					$("#pasien_detail_resep").load("content/pasien/catatresep/nama_obat.php?id_pasien="+id_pasien+"&id_kunjungan="+id_kunjungan+"&id_kategori_harga="+<?php echo $id_kategori_harga?>);
				}
			});

		});

		/*      */
		$('body').on('change', '[name=jumlah_perhari]', function (){ 
		    var h =  $(this).val(); 
		    var n =  $('[name=number_of_day]').val();
		    var q =  $('[name=diberi]').val();   
		    if(!h){h=0;}  if(!n){n=0;}  if(!q){q=0;}

		    $('#dosis').val(q+"x"+h);  


            
			
            });
		$('body').on('change', '[name=number_of_day]', function (){ 
		    var n =  $(this).val(); 
		    var h =  $('[name=jumlah_perhari]').val();
		    var q =  $('[name=diberi]').val();   
		    if(!h){h=0;}  if(!n){n=0;}  if(!q){q=0;}

		    $('#dosis').val(q+"x"+h); 

		     total = q*n*h;
		    $('#total_obat').val(total);  	      
            
			
            });

		$('body').on('change', '[name=diberi]', function (){ 

		    var q =  $(this).val(); 
		    var n =  $('[name=number_of_day]').val();
		    var h =  $('[name=jumlah_perhari]').val();   
		    if(!h){h=0;}  if(!n){n=0;}  if(!q){q=0;}

		    $('#dosis').val(q+"x"+h);   
		   	
            });




		</script>
		
	