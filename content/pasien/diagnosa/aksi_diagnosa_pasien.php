<?php
session_start();
error_reporting(1);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";

	?>
		 <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="assets/css/modal.css" rel="stylesheet">
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/datatable_code.js"></script>
        <script src="assets/js/dataTables.bootstrap4.min.js"></script>

	<?php

	$module=$_GET['module'];
	$act=$_GET['act'];
	if ($module=='diagnosa' AND $act=='input'){
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		$catatan=$_POST['catatan'];
		
		
		$result=pg_query($dbconn,"INSERT INTO pasien_diagnosa (id_user, versi, tgl_diagnosa, catatan, id_unit, id_pasien, id_kunjungan)
		 VALUES (
		 	'$_SESSION[login_user]',
		 	'1',
		 	'$tgl_sekarang',
		 	'$catatan',
			'$_SESSION[id_units]',
			'$id_pasien',
			'$id_kunjungan'

		) RETURNING id");

					
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		
			
		$data=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail WHERE id_pasien='$_POST[id_pasien]' AND id_kunjungan='$_POST[id_kunjungan]' AND status_temp='Y'");
		
		
		while($r=pg_fetch_array($data)){
				
			pg_query($dbconn,"UPDATE pasien_diagnosa_detail SET id_pasien_diagnosa='$insert_id', status_temp='N' WHERE id='$r[id]'");
			
		}
		
		
		
		?>
		
		<div class="card">
		<div class="card-header">
			<strong>Data Diagnosa</strong>
			<span class="pull-right">
				<?php
				if($id_kunjungan!=''){
					?>
					<button type="button" class="btn btn-primary btn-xs btnTambahDiagnosa">Tambah</button>
					<?php
				}
				else{
				?>
					<button type="button" class="btn btn-primary btn-xs btnTambahDiagnosa" disabled>Tambah</button>
				<?php
				}
				?>
			</span>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Catatan</th>
								<th>Tipe Diagnosa</th>
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php

								$tampil=pg_query($dbconn,"SELECT * FROM pasien_diagnosa pd
														WHERE  pd.status_hapus='N' and pd.id_pasien='$id_pasien' ");
								
								while($data=pg_fetch_array($tampil)){
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT type_diagnosa FROM pasien_diagnosa_detail WHERE id_pasien_diagnosa='$data[id]'"));

									if($a['type_diagnosa']=='N'){
										$type='ICD10';
										
									}else{
										$type='ICPC';
										
									}
									
									
									?>
									<tr>
										<td><?php echo $data['tgl_diagnosa'];?></td>
										<td><?php echo $data['catatan'];?></td>
										<td><?php echo $type;?></td>
										
										<td>
											<button class="btn btn-primary btn-xs btnViewDiagnosa" 
											id="<?php echo $data['id'];?>" title="View">
											<i class="icon-eye"></i>
											</button>
											<button class="btn btn-info btn-xs btnHapusDiagnosa" id="<?php echo $data['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
											
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
	</div>
<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(function () {
	
	$('.btnTambahDiagnosa').click(function()
	{
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		$.ajax({
			type: 'POST',
			url: 'content/pasien/diagnosa/aksi_diagnosa_pasien.php?module=diagnosa&act=inputform',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#data_diagnosa").html(msg);
			}
		});
		
	});
	
	$(".btnViewDiagnosa").click(function(){
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
		//alert(dataString2);
		$.ajax({
			type: 'POST',
			url: 'aksi-view-pasien-diagnosa',
			data: dataString2,
			success: function(msg){
				$("#data_diagnosa").html(msg);
			}
		});
		
		
	});
	$(".btnHapusDiagnosa").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus diagnosa ini?")){
			var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			alert("hapus");
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-diagnosa',
				data: dataString2,
				success: function(msg){
						//alert("msg");
					$("#data_diagnosa").html(msg);
				}
			});
		}
		else{
			return false;
		}
	});
});
</script>
		<?php
		
	}
	
	
	elseif ($module=='diagnosa' AND $act=='inputform'){
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		
		?>
		<div class="card">
			<div class="card-header">
				<strong>Tambah</strong>
			</div>
			<div class="card-block">
				<div class="row">
						<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $_POST['id_pasien'];?>">
						<input type="hidden" name="no_rm" id="no_rm" value="<?php echo $_POST['no_rm'];?>">
							<input type="hidden" name="id_pasien" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
					
					
					<div class="col-md-5">
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkiri1" role="tab" aria-controls="tabkiri1">ICD10</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabkiri2" role="tab" aria-controls="tabkiri2">ICPC</a>
                                </li>
                            </ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tabkiri1" role="tabpanel" >
									<br>
							
									
									<div class="form-group data-lab" id="data_lab"  style="overflow-y: scroll; min-height: 500px;">
										

										 <table id="lookup" class="table table-bordered table-striped">  
		                                     <thead align="center">
		                                        <tr>
		    
		                                       
		                                      <th>Kode </th>
		                                        <th>Nama </th>
		                                      <th class="text-center"> Action </th> 
		    
		                                       </tr>
		                                      </thead>
		                                        <tbody>
		                                        </tbody>
		                                    </table>
									</div>
								</div>
								<div class="tab-pane" id="tabkiri2" role="tabpanel">
									<br>
							
									
									<div class="form-group data-icpc" id="data_icpc" >
										

										 <table style="overflow-y: scroll; min-width: 350px;" id="lookup_icpc" class="table table-bordered table-striped">  
		                                     <thead align="center">
		                                        <tr>
		    
		                                       
		                                      <th>Kode </th>
		                                        <th>Nama </th>
		                                      <th class="text-center"> Action </th> 
		    
		                                       </tr>
		                                      </thead>
		                                        <tbody>
		                                        </tbody>
		                                    </table>
									</div>
								</div>
								
								
							</div>
							
					</div>
					
					<div class="col-md-7">
						<fieldset>
							<legend>Hasil Diagnosa</legend>
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkanan1" role="tab" aria-controls="tabkanan1"></a>
                                </li>
                                
                            </ul>
							
							<div class="tab-content">
								<div class="tab-pane active" id="tabkanan1" role="tabpanel">
									<br>
									<div class="form-group data-lab2" id="data_diagnosa_kanan">
										<table class="table">
											<thead>
												<th>Diagnosa Terpilih</th>
												<th>Status</th>
												<th width="50px">#</th>
											</thead>
											<tbody>
												<?php
												$tampil=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'");
													while($r=pg_fetch_array($tampil)){
														if($r['status']==1)
														{
															$status="Primer";
														}
														else
														{
															$status="Sekunder";
														}
												if($r['type_diagnosa']=='1'){
														if($r['id_diagnosa']!=NULL){
														$a=pg_fetch_array(pg_query($dbconn,"SELECT  nama FROM master_icpc WHERE id='$r[id_diagnosa]'"));
														?>
														<tr>
															<td><b>ICPC </b><?php echo $a['nama'];?></td>
															<td ><?php echo $status;?></td>
															<td>
																<button class="btn btn-danger btn-xs btnHapusDiagnosaPilih" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
															</td>
														</tr>
													<?php	
													}
												}
												else{
													if($r['id_diagnosa']!=NULL){
														$a=pg_fetch_array(pg_query($dbconn,"SELECT  nama FROM master_icd10 WHERE id='$r[id_diagnosa]'"));
														?>
														<tr>
															<td><b>ICD10 </b><?php echo $a['nama'];?></td>
															<td ><?php echo $status;?></td>
															<td>
																<button class="btn btn-danger btn-xs btnHapusDiagnosaPilih" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
															</td>
														</tr>
													<?php	
													}

													
												}
												
												}
												
												?>
											</tbody>
										</table>
									</div>
								</div>
								
								
							</div>
							</fieldset>
						<div class="form-group row">
							<label class="col-md-2">Catatan</label>
							<div class="col-md-9">
								<input name="catatan" id="catatan"  class="form-control">
												
							</div>
						</div>
						<div class="form-group row">
										<label class="col-md-2">Tipe Diagnosa</label>
										<div class="col-md-8">
											<select name="tipe_diagnosa" id="tipe_diagnosa" class="form-control">
												<option value="Confirmed">Confirmed</option>
												<option value="Differential">Differential</option>
												<option value="Provisional">Provisional</option>
												
											</select>
										</div>
						</div>
						

					</div>
					
					<div class="col-md-12">
						<button type="button" class="btn btn-primary btn-sm" id="btnSimpanDiagnosa">Simpan</button>
						<button type="button" class="btn btn-danger btn-sm" id="btnBatalDiagnosa">Batal</button>
					</div>
				</div>
			</div>
		</div>
		<script src="assets/plugins/select2/select2.full.min.js"></script>
		<script>

		 $(document).ready(function() {
                var dataTable = $('#lookup').DataTable( {
                  "language": {
                    "search": "Cari:",
                    "sLengthMenu": "Tampilkan _MENU_ "

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

                //icpc
                var dataTable = $('#lookup_icpc').DataTable( {
                  "language": {
                    "search": "Cari:",
                    "sLengthMenu": "Tampilkan _MENU_ "

                        },
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                        url :"content/pasien/diagnosa_icpc/ajax-grid-data-icpc.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                            $(".lookup_icpcerror").html("");
                            $("#lookup_icpc").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#lookup_icpc_processing").css("display","none");
                            
                        }
                    }
                } );
            } );
		
		$(document).ready(function(){
			$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
			
			 $('.js-example-basic-single').select2();
		});
		
		$(function () {
			
			
			$("#group_diagnosa").change(function(){
				var id_group=$(this).val();
				//alert(id_group);
				$.ajax({
					type 	: 'POST',
					url 	: 'data-diagnosa',
					data: { 
						'name_group': id_group
					},
					success	: function(response){
						//alert(response);
						$('#data_lab').html(response);
					}
				});
			});
		});


		$('body').on('click', '.btnTambahDiagnosa', function (){
			

			var id_diagnosa=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_diagnosa='+id_diagnosa;
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pesan-diagnosa",
				data: dataString,
				cache: false,
				success: function(data){
					$("#data_diagnosa_kanan").html(data);
				}
			});

		});
		$('body').on('click', '.btnTambahDiagnosaIcpc', function (){
			
			//alert("ICPC");
			var type_diagnosa='1';
			var id_diagnosa=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_diagnosa='+id_diagnosa+'&type_diagnosa='+type_diagnosa;
			//alert(dataString);
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pesan-diagnosa",
				data: dataString,
				cache: false,
				success: function(data){
					$("#data_diagnosa_kanan").html(data);
				}
			});

		});
		
		

		
		
		
		$('#btnSimpanDiagnosa').click(function()
		{
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var catatan = $("#catatan").val();
			var tipe_diagnosa = $("#tipe_diagnosa").val();
			//alert(catatan);
			
			
			
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&catatan='+catatan+'&tipe_diagnosa'+tipe_diagnosa;
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pasien-diagnosa",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnSimpanDiagnosa").val('Submitting...');},
				success: function(data){
					//alert(data);
					$("#data_diagnosa").html(data);
				}
			});
		});
		
		$('#btnBatalDiagnosa').click(function()
		{
			var no_rm=$("#no_rm").val();

			$("#data_diagnosa").load("content/pasien/diagnosa/pasien_diagnosa.php?id="+no_rm);

		});
		
		
		$('.btnHapusDiagnosaPilih').click(function(){
			if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
				var id=this.id;
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
				$.ajax({
					type: "POST",
					url: "aksi-hapus-pasien-diagnosa-detail",
					data: dataString,
					cache: false,
					success: function(data){
						$("#data_diagnosa_kanan").html(data);
					}
				});
			}
			else{
				return false;
			}
		});
		
		</script>

	<?php
	}
	
	elseif ($module=='diagnosa' AND $act=='delete'){
		pg_query($dbconn,"DELETE from pasien_diagnosa_detail WHERE id='$_POST[id]'");
		
		
	
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<table class="table">
			<thead>
				<th>Diagnosa Terpilih</th>
				<th>Status</th>
				<th width="50px">#</th>
			</thead>
			<tbody>
			<?php
			$tampil=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'");
			while($r=pg_fetch_array($tampil)){
				if($r['status']==1)
				{
					$status="Primer";
				}
				else
				{
					$status="Sekunder";
				}
				if($r['id_diagnosa']!=NULL){
														$a=pg_fetch_array(pg_query($dbconn,"SELECT  nama FROM master_icd10 WHERE id='$r[id_diagnosa]'"));
														?>
														<tr>
															<td ><?php echo $a['nama'];?></td>
															<td ><?php echo $status ?></td>
															<td>
																<button class="btn btn-danger btn-xs btnHapusDiagnosaPilih" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
															</td>
														</tr>
												<?php		
													}
													
												}
												?>
											</tbody>
		</table>
		
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		<script>
			$(function () {
				$('.btnHapusDiagnosaPilih').click(function(){
			if(window.confirm("Apakah Anda yakin ingin menghapus diagnosa ini?")){
				var id=this.id;
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
				$.ajax({
					type: "POST",
					url: "aksi-hapus-pasien-diagnosa-detail",
					data: dataString,
					cache: false,
					success: function(data){
						$("#data_diagnosa_kanan").html(data);
					}
				});
			}
			else{
				return false;
			}
		});
			});
		</script>
		<?php
	}
	
	elseif ($module=='diagnosa' AND $act=='data'){
		
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		
		echo"
		<input type='hidden' id='id_pasien' value='$id_pasien'>
		<input type='hidden' id='id_kunjungan' value='$id_kunjungan'>
		";?>
		<div class="card">
		<div class="card-header">
			<strong>Data Diagnosa</strong>
			<span class="pull-right">
				<?php
				if($id_kunjungan!=''){
					?>
					<button type="button" class="btn btn-primary btn-xs btnTambahDiagnosa">Tambah</button>
					<?php
				}
				else{
				?>
					<button type="button" class="btn btn-primary btn-xs btnTambahDiagnosa" disabled>Tambah</button>
				<?php
				}
				?>
			</span>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Catatan</th>
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php

								$tampil=pg_query($dbconn,"SELECT * FROM pasien_diagnosa pd
														WHERE  pd.status_hapus='N' and pd.id_pasien='$id_pasien' ");
								
								while($data=pg_fetch_array($tampil)){
									

									$a=pg_fetch_array(pg_query($dbconn,"SELECT a.detail_segmen, a.id_paket, b.keterangan FROM antrian a, segmen b WHERE a.id_segmen=b.id AND a.id_kunjungan='$data[id_kunjungan]'  AND a.status_aktif='Y'"));

									$nama_icd10=$a['nama'];
									$code= $a['code'];
																		
									?>
									<tr>
										<td><?php echo $data['tgl_diagnosa'];?></td>
										<td><?php echo $data['catatan'];?></td>
										<td>
											<button class="btn btn-primary btn-xs btnViewDiagnosa" 
											id="<?php echo $data['id'];?>" title="View">
											<i class="icon-eye"></i>
											</button>
											<button class="btn btn-info btn-xs btnHapusDiagnosa" id="<?php echo $data['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
											
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
	</div>
		
	<script type="text/javascript">
$(function () {
	
	$('.btnTambahDiagnosa').click(function()
	{
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		//alert("on");
		$.ajax({
			type: 'POST',
			url: 'content/pasien/diagnosa/aksi_diagnosa_pasien.php?module=diagnosa&act=inputform',
			data: dataString2,			
			success: function(msg){
				$("#data_diagnosa").html(msg);
			}
		});
		
	});
	
	$(".btnViewDiagnosa").click(function(){
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
		//alert(dataString2);
		$.ajax({
			type: 'POST',
			url: 'aksi-view-pasien-diagnosa',
			data: dataString2,
			success: function(msg){
				$("#data_diagnosa").html(msg);
			}
		});
		
		
	});
	
	
	
	$(".btnHapusDiagnosa").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus diagnosa ini?")){
			var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			alert("hapus");
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-diagnosa',
				data: dataString2,
				success: function(msg){
						//alert("msg");
					$("#data_diagnosa").html(msg);
				}
			});
		}
		else{
			return false;
		}
	});
});
</script>
		<?php
	}
	
	elseif ($module=='diagnosa' AND $act=='inputandiagnosa'){
		$id_pasien=$_POST['id_pasien'];
		$id_diagnosa=$_POST['id_diagnosa'];
		$id_kunjungan=$_POST['id_kunjungan'];
		$type_diagnosa=$_POST['type_diagnosa'];

		
		/*$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_diagnosa_detail WHERE id_diagnosa='$id_diagnosa' AND id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'"));
	
		if($c['tot']==0){
			$data=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail WHERE id_pasien='$id_pasien' AND status_temp='Y' AND id_kunjungan='$id_kunjungan' ");
	
			$ada=0;
			
			$cp=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_diagnosa_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'"));
			if($cp['total']){
			pg_query($dbconn,"INSERT INTO pasien_diagnosa_detail (id_diagnosa,  id_pasien, id_kunjungan, status_temp, id_unit, status) VALUES ('$_POST[id_diagnosa]',  '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'Y', '$_SESSION[id_units]')");
					
			}
		}*/
		if($type_diagnosa!='1'){
			$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_diagnosa_detail WHERE id_diagnosa='$id_diagnosa' AND id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'"));
	
			if($c['tot']==0){
				$data=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail WHERE id_pasien='$id_pasien' AND status_temp='Y' AND id_kunjungan='$id_kunjungan' ");
		
				$ada=0;
				$countData=pg_query("SELECT count(*) as jumlah from pasien_diagnosa_detail where id_pasien='$id_pasien' and id_kunjungan='$id_kunjungan' and id_pasien_diagnosa is NULL");
				$row=pg_fetch_assoc($countData);
				if($row['jumlah']==0)			
				{
					$statusPriority="1";
				}
				else
				{
					$statusPriority="2";
				}
						
				pg_query($dbconn,"INSERT INTO pasien_diagnosa_detail (id_diagnosa,  id_pasien, id_kunjungan, status_temp, id_unit,status) VALUES ('$_POST[id_diagnosa]',  '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'Y', '$_SESSION[id_units]', '$statusPriority')");
						
			}
		}
		else if($type_diagnosa=='1'){
			$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_diagnosa_detail WHERE id_diagnosa='$id_diagnosa' AND id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y' AND type_diagnosa='$type_diagnosa'"));
	
			if($c['tot']==0){
				$data=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail WHERE id_pasien='$id_pasien' AND status_temp='Y' AND id_kunjungan='$id_kunjungan' AND type_diagnosa='$type_diagnosa' ");
		
				$ada=0;
				$countData=pg_query("SELECT count(*) as jumlah from pasien_diagnosa_detail where id_pasien='$id_pasien' and id_kunjungan='$id_kunjungan' and id_pasien_diagnosa is NULL");
				$row=pg_fetch_assoc($countData);
				if($row['jumlah']==0)			
				{
					$statusPriority="1";
				}
				else
				{
					$statusPriority="2";
				}
						
				pg_query($dbconn,"INSERT INTO pasien_diagnosa_detail (id_diagnosa,  id_pasien, id_kunjungan, status_temp, id_unit,status,type_diagnosa) VALUES ('$_POST[id_diagnosa]',  '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'Y', '$_SESSION[id_units]', '$statusPriority', '$type_diagnosa')");
						
			}
		}
		if($ada==1){
			echo"sudah_ada";
		}
		else{
		?>
		<table class="table">
			<thead>
				<th>Diagnosa Terpilih</th>
				<th>Status</th>
				<th width="50px">#</th>
			</thead>
			<tbody>
												<?php
												$tampil=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'");
													while($r=pg_fetch_array($tampil)){
														if($r['status']==1)
														{
															$status="Primer";
														}
														else
														{
															$status="Sekunder";
														}
												if($r['type_diagnosa']=='1'){
														if($r['id_diagnosa']!=NULL){
														$a=pg_fetch_array(pg_query($dbconn,"SELECT  nama FROM master_icpc WHERE id='$r[id_diagnosa]'"));
														?>
														<tr>
															<td><b>ICPC </b><?php echo $a['nama'];?></td>
															<td ><?php echo $status;?></td>
															<td>
																<button class="btn btn-danger btn-xs btnHapusDiagnosaPilih" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
															</td>
														</tr>
													<?php	
													}
												}
												else{
													if($r['id_diagnosa']!=NULL){
														$a=pg_fetch_array(pg_query($dbconn,"SELECT  nama FROM master_icd10 WHERE id='$r[id_diagnosa]'"));
														?>
														<tr>
															<td><b>ICD10 </b><?php echo $a['nama'];?></td>
															<td ><?php echo $status;?></td>
															<td>
																<button class="btn btn-danger btn-xs btnHapusDiagnosaPilih" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
															</td>
														</tr>
													<?php	
													}

													
												}
												
												}
												
												?>
											</tbody>
		</table>
		<?php 
		}
		?>
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		<script>
			$(function () {
				$('.btnHapusDiagnosaPilih').click(function(){
			if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
				var id=this.id;
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
				$.ajax({
					type: "POST",
					url: "aksi-hapus-pasien-diagnosa-detail",
					data: dataString,
					cache: false,
					success: function(data){
						$("#data_diagnosa_kanan").html(data);
					}
				});
			}
			else{
				return false;
			}
		});
			});
		</script>
		<?php
		}	
	
	elseif($module=='diagnosa' AND $act=='hapus'){

	$p=pg_query($dbconn,"Update pasien_diagnosa set status_hapus='Y' WHERE id='$_POST[id]'");
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
		
		echo"
		<input type='hidden' id='id_pasien' value='$id_pasien'>
		<input type='hidden' id='id_kunjungan' value='$id_kunjungan'>
		";?>
		<div class="card">
		<div class="card-header">
			<strong>Data Diagnosa</strong>
			<span class="pull-right">
				<?php
				if($id_kunjungan!=''){
					?>
					<button type="button" class="btn btn-primary btn-xs btnTambahDiagnosa">Tambah</button>
					<?php
				}
				else{
				?>
					<button type="button" class="btn btn-primary btn-xs btnTambahDiagnosa" disabled>Tambah</button>
				<?php
				}
				?>
			</span>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								<th>Tanggal</th>								
								<th>Catatan</th>
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php

								$tampil=pg_query($dbconn,"SELECT * FROM pasien_diagnosa pd
														WHERE  pd.status_hapus='N' and pd.id_pasien='$id_pasien' ");
								
								while($data=pg_fetch_array($tampil)){
									

									$a=pg_fetch_array(pg_query($dbconn,"SELECT a.detail_segmen, a.id_paket, b.keterangan FROM antrian a, segmen b WHERE a.id_segmen=b.id AND a.id_kunjungan='$data[id_kunjungan]'  AND a.status_aktif='Y'"));

									$nama_icd10=$a['nama'];
									$code= $a['code'];
																		
									?>
									<tr>
										<td><?php echo $data['tgl_diagnosa'];?></td>
										
										<td><?php echo $data['catatan'];?></td>
										
										<td>
											<button class="btn btn-primary btn-xs btnViewDiagnosa" 
											id="<?php echo $data['id'];?>" title="View">
											<i class="icon-eye"></i>
											</button>
											<button class="btn btn-info btn-xs btnHapusDiagnosa" id="<?php echo $data['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
											
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
	</div>
		
<script type="text/javascript">
$(function () {
	
	$('.btnTambahDiagnosa').click(function()
	{
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		//alert("on");
		$.ajax({
			type: 'POST',
			url: 'content/pasien/diagnosa/aksi_diagnosa_pasien.php?module=diagnosa&act=inputform',
			data: dataString2,			
			success: function(msg){
				$("#data_diagnosa").html(msg);
			}
		});
		
	});
	
	$(".btnViewDiagnosa").click(function(){
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
		alert(dataString2);
		$.ajax({
			type: 'POST',
			url: 'aksi-view-pasien-diagnosa',
			data: dataString2,
			success: function(msg){
				$("#data_diagnosa").html(msg);
			}
		});
		
		
	});
	
	
	
	$(".btnHapusDiagnosa").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus diagnosa ini?")){
			var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			alert("hapus");
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-diagnosa',
				data: dataString2,
				success: function(msg){
						//alert("msg");
					$("#data_diagnosa").html(msg);
				}
			});
		}
		else{
			return false;
		}
	});
});
</script>


<?php
}
elseif($module=='diagnosa' AND $act=='view'){


 $v=pg_fetch_array(pg_query($dbconn,"Select * from pasien_diagnosa WHERE id='$_GET[id]'"));
?>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div id="data_jadwal">

			<div class="card">
				<div class="card-header">
					<div class="col-md-6 text-left">
						<strong>View Hasil Diagnosis </strong>
					</div>
				</div>
				<div class="card-block">
					<div class="row">
						<?php
						$id_pasien=$_POST['id_pasien'];
						$id_kunjungan=$_POST['id_kunjungan'];
						$qry="SELECT p.*, d.* FROM pasien_diagnosa p 
						LEFT OUTER JOIN  pasien_diagnosa_detail d ON d.id_pasien_diagnosa=p.id
						WHERE  p.status_hapus='N' AND d.id_pasien='".$id_pasien."' AND d.id_kunjungan='".$id_kunjungan."' AND p.id='".$_POST['id']."'
						ORDER BY d.id DESC";
						//var_dump($qry);
						$tampil=pg_query($dbconn,$qry);
									
									
						?>
							<table class="table" id="myTable">
								
								<tr>
									<td>Diagnosa</td><td>:</td>
									
									<td>
									<?php												
										while($r=pg_fetch_array($tampil)){
											if($r['type_diagnosa']=='N'){
												$type="ICD10";
											$a=pg_fetch_array(pg_query($dbconn,"SELECT code, nama FROM master_icd10  WHERE id='$r[id_diagnosa]'"));

											if($r['status']==1)
												{
													$status="Premier";
												}
												else
												{
													$status="Sekunder";
												}

											?>
											<li><?php echo $status."--".$a[nama];?></li>
											
										<?php 
										}
										if($r['type_diagnosa']=='1'){
												$type="ICPC";
											$a=pg_fetch_array(pg_query($dbconn,"SELECT kode, nama FROM master_icpc  WHERE id='$r[id_diagnosa]'"));
											//var_dump("SELECT code, nama FROM master_icpc  WHERE id='$r[id_diagnosa]'");

											if($r['status']==1)
												{
													$status="Premier";
												}
												else
												{
													$status="Sekunder";
												}

											?>
											<li><?php echo $status."--".$a[nama];?></li>
											
										<?php 
										}
										}
									
										?>
									</td>
									
								</tr>
								<tr>
									<td>List</td><td>:</td>
									
									<td><?php echo $type;?></td>
									
								</tr>
								
								
							</table>
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-default btn-sm" id="btnbatalviewDiagnosa">Kembali</button>
						
				</div>
			</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(function () {
	
	$('#btnbatalviewDiagnosa').click(function()
	{
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		$.ajax({
			type: 'POST',
			url: 'data-pasien-diagnosa1',
			data: dataString2,
			cache: false,
			success: function(msg){
				
				$("#data_diagnosa").html(msg);
			}
		});
		
	});
	
	
});
</script>
<?php

	}

elseif ($module=='diagnosa' AND $act=='data_diagnosa'){
		$id_group=$_POST['name_group'];
		$id_group = explode("_", $id_group);
		$awal=$id_group[0];
		$akhir=$id_group[1];

		if(!$id_group){
				$awal='1';
				$akhir='390';
		}
		//var_dump("SELECT * FROM master_icd10 where id between  '$awal' AND '$akhir' ");	
		
		
		?>
		<table class="table table-condensed" id="myTable">
		<thead>
		<th>Kode</th>
		<th>Diagnosa</th>
		<th width="50px">#</th>
		</thead>
		<tbody>
		<?php
		$tampil=pg_query($dbconn,"SELECT * FROM master_icd10 where id between  '$awal' AND '$akhir' ");
		
		while($r=pg_fetch_array($tampil)){
		?>
			<tr><td><?php echo $r['code'];?></td>
			<td><?php echo $r['nama'];?></td>
			<td><button class="btn btn-default btn-xs btnTambahDiagnosa" id="<?php echo $r['id'];?>"><i class="icon-plus"></i></button></td>
	  		 </tr><?php
		}			?>
		</tbody>
		</table>
		<script>
		
		
		$(function () {	

		$('.btnTambahDiagnosa').click(function(){
		
			var id_diagnosa=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_diagnosa='+id_diagnosa;
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pesan-diagnosa",
				data: dataString,
				cache: false,
				success: function(data){
					$("#data_diagnosa_kanan").html(data);
				}
			});
		});
		});
		
		</script>
		
		<?php
	}
	pg_close($dbconn);
}

?>