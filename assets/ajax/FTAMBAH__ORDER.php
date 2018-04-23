<?php 
session_start();

$id_pasien=$_POST['id_pasien'];
$id_kunjungan=$_POST['id_kunjungan'];
$id_kategori_harga=$_POST['id_kategori_harga'];
$view_dokter=pg_fetch_array(pg_query($dbconn,"Select id_dokter from antrian where id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan'"));

$id_dokter=$view_dokter['id_dokter'];


		
		?>
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien"> 	
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<input type="hidden" name="id_kategori_harga" value="<?php echo $id_kategori_harga;?>" id="id_kategori_harga">
		<input type="hidden" name="rm" value="<?php echo $_POST[rm];?>" id="rm">
		<div class="card">
			<div class="card-header">
				<strong>Tambah </strong>
			</div>
			<div class="card-block">
				<div class="row">
						<div class="col-md-12">
					<div class="form-group row">
						<label class="col-md-3 form-control-label">Keterangan</label>
						<div class="col-md-9">
							<textarea name="keterangan" id="keterangan"  class="form-control" placeholder="Keterangan/Catatan"></textarea>
						</div>
					</div>
				</div>
					
				<div class="col-md-12">
				<fieldset>
					<legend>Daftar TIndakan</legend>
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
	                        <a class="nav-link active" data-toggle="tab" href="#tabkiri3" role="tab" aria-controls="tabkiri2">Tindakan</a>
	                    </li>
	                    <li class="nav-item" style="display:none;">
	                        <a class="nav-link" data-toggle="tab" href="#tabkiri1" role="tab" aria-controls="tabkiri1">Laboratoriumm</a>
	                    </li>
                    </ul>
					<div class="tab-content">
				<div class="tab-pane" id="tabkiri1" role="tabpanel" style="overflow-y: scroll;">
				<br>
				 <table id="myTable6" class="table">
                    <thead class="table-info" style="display:;">
                    <tr>
                    <th width="10px"></th>
                      <th width="">Nama</th> 
                    </tr>
                    </thead>
                    <tbody style="display:;">                   
                         <?php
			                 $res=pg_query($dbconn,"Select * from lab_analysis");	                                 
			                 while ($row=pg_fetch_assoc($res)) {
			                   
                                       ?>
                                         <tr>
                                          <td>
                                          <input style="vertical-align:left; margin: 5px" type="checkbox"  value="<?php echo $row['id']."_".$row["harga_modal"]; ?>" name="lab_analysis[]" class="stest" harga="<?php echo $row["harga"]; ?>"/>
                                          </td>
                                          
                                          <td class="text-left" ><?php echo $row["nama"] ?></td>
                                                                         
                                         
		                        </tr>     

		                        <?php
		                        }
		                        ?>
                        </tbody>                 
                </table>
				</div>
			
				<div class="tab-pane active" id="tabkiri3" role="tabpanel">
				<div class="form-group ">
				  <table id="myTable5" class="table">
	                <thead class="table-info">
                <tr>
                <th width="10px"></th>
                  <th width="">Nama</th>
                  <th width="" style="display:none;">Harga</th>                             
                
                  
                </tr>
                </thead>
                <tbody>
                    <?php
					 $id_regional = $_SESSION['id_regional'];
					 //if region
					 /*$res=pg_query($dbconn,"Select id, id_tindakan, harga from tindakan_kategori_harga_unit where id_regional='$id_regional' and id_kategori_harga='$id_kategori_harga' order by id_tindakan asc");*/
					 $res=pg_query($dbconn,"Select  id_tindakan, harga from tindakan_dokter_unit where id_karyawan='$id_dokter' and id_unit='$_SESSION[id_units]' order by id_tindakan asc");

				
					while ($row=pg_fetch_assoc($res)) {
							$data=pg_fetch_array(pg_query($dbconn,"Select * from tindakan where id='".$row["id_tindakan"]."' "));
                                       ?>
                                         <tr>
                                          <td><input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id_tindakan']."_". $row["harga"]?>" name="tindakan[]" class="nonlab" harga="<?php echo $row["harga"];?>"/></td>
                                         
                                          <td class="text-left"><?php echo $data["nama"] ?></td>
                                          
                                          <td style="display:none;">
                                          <input style="vertical-align:left; margin: 5px; border: none;" type="text" 
                                          value="<?php echo number_format($row["harga"], 0,',','.')  ?>" name="harga_tindakan[]" readonly class="text-right" />
                                                                                     
                                          </td>
                                     
                                         
                                      </tr>
                                     <?php 
					                    } 
					                  ?> 
					                     </tbody>
					                     </table>
									</div>
									</div>
													
							</div>
						</fieldset>
					</div>				
					<div class="col-md-12">
						<button type="button" class="btn btn-primary btn-sm" id="btnSimpanLaborder">Simpan</button>
						<button type="button" class="btn btn-danger btn-sm" id="btnBatalLaborder">Batal</button>
					</div>
				</div>
			</div>
		</div>

		<script>

		$('#btnSimpanLaborder').click(function(){
       
      		  	var id_kategori_harga=$("#id_kategori_harga").val();
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var keterangan=$("#keterangan").val();
				var rm=$("#rm").val();

				
              var checkbox_single_test = [];
                  $("input[name='lab_analysis[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox_single_test.push($(this).val());
                    }

                  });

  

              var checkbox_non_lab = [];
                  $("input[name='tindakan[]']").each(function ()
                  {
                       if ($(this).is(':checked')) {
                      checkbox_non_lab.push($(this).val());
                    }
                  });

             
               

                $.ajax({
                         type:'post',
                         url :"media.php?ajax=SIMPAN__ORDER",
                          data:{  
                                            checkbox_single_test:checkbox_single_test, 
                                            checkbox_non_lab:checkbox_non_lab,
                                            id_kategori_harga:id_kategori_harga,
                                            id_pasien:id_pasien,
                                            id_kunjungan:id_kunjungan,
                                            keterangan:keterangan
                                  },
                         success: function(data) {    
                         	//alert(data);
                         	$("#data_order").load('content/pasien/order/pasien_order.php?id='+rm);
                         }                                                           
 
                         });
             
              });

		$(document).ready(function(){
			$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
			
			 $('.js-example-basic-single').select2();
		});
		
		$(function () {
			$("#id_specimen").change(function(){
				var id_specimen=$(this).val();
				var id_kategori=$("#id_kategori").val();
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				
				var dataString = 'id_specimen='+id_specimen+'&id_kategori='+id_kategori+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
				
				$.ajax({
					type 	: 'POST',
					url 	: 'data-lab',
					data	: dataString,
					success	: function(response){
						$('#data_lab').html(response);
					}
				});
			});
			
			$("#id_kategori").change(function(){
				var id_kategori=$(this).val();
				var id_specimen=$("#id_specimen").val();
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val()
				
				var dataString = 'id_specimen='+id_specimen+'&id_kategori='+id_kategori+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
				$.ajax({
					type 	: 'POST',
					url 	: 'data-lab',
					data	: dataString,
					success	: function(response){
						$('#data_lab').html(response);
					}
				});
			});
		});
		
	/*	
		$('.btnTambahPesanAnalysis').click(function(){
			var id_analysis=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_analysis='+id_analysis;
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pesan-analysis",
				data: dataString,
				cache: false,
				success: function(data){
					$("#data_laborder_kanan").html(data);
				}
			});
		});*/
		
		
		/*$('.btnTambahPesanAnalysisGroup').click(function(){
			var id_analysis_group=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_analysis_group='+id_analysis_group;
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pesan-analysis-group",
				data: dataString,
				cache: false,
				success: function(data){
					$("#data_laborder_kanan").html(data);
				}
			});
		});*/
		
		
		
		$('#btnBatalLaborder').click(function()
		{
				
				var rm=$("#rm").val();
				$("#data_order").load('content/pasien/order/pasien_order.php?id='+rm);
		});
		
		
		$('.btnHapusPesanAnalysis').click(function(){
			if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
				var id=this.id;
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
				$.ajax({
					type: "POST",
					url: "aksi-hapus-pesan-analysis",
					data: dataString,
					cache: false,
					success: function(data){
						$("#data_laborder_kanan").html(data);
					}
				});
			}
			else{
				return false;
			}
		});

	
		
		</script>

