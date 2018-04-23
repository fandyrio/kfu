<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";

	$module=$_GET['module'];
	$act=$_GET['act'];
	if($module=='hasillab' AND $act=='data'){
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		$id_pasien_order=$_POST['id_pasien_order'];
		?>
		
		<div class="card">
			<div class="card-header">
				<strong>Data Hasil Lab</strong>
				<span class="pull-right">
				</span>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<table class="table">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Jenis Pemeriksaan</th>
									<th>Detail</th>
									<th>No RM</th>
									<th>Status</th>
									<th width="100px">#</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT t.* from transaksi_invoice_detail t
									INNER JOIN pasien_order p on p.id=t.id_pasien_order and p.id_pasien=t.id_pasien
									WHERE p.id_pasien='$id_pasien' and t.id_pasien='$id_pasien' 
																   and t.id_kunjungan='$id_kunjungan' and t.jenis <>'N'");
							
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);

									 if($r['jenis']=='E'){
											
											$a=pg_fetch_array(pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$r[id_detail]' order by d.id_detail "));
											$jenis="MCU";
											$nama_transaksi=$a[nama_paket];										
											
										}
										
										elseif($r['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
											$jenis= "SINGLE TEST";								
											$nama_transaksi=$a[nama];
											
											
										}
										elseif($r['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
											$jenis="Multiple Test";
											$nama_transaksi=$a[nama];
											
										}
									
										elseif($r['status_order']==3){
											$status="<button class='btn btn-xs btn-success' title='hasil'><i class='icon-check'></i></button>";
										
										}
										else{
											$status="<button class='btn btn-xs btn-warning' title='proses'>-</button>";
										}
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $jenis; ?></td>
										<td><?php echo $nama_transaksi;?></td>
										<td><?php echo $_POST[id];?></td>
										<td><?php echo $status;?></td>
										<td>

											
											<button class="btn btn-primary btn-xs btnEditLabhasil" id_order="<?php echo $r[id_pasien_order];?>" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
											<button class="btn btn-info btn-xs btnViewLabhasil" id="<?php echo $r['id'];?>"><i class="icon-eye"></i></button>
											<?php
												if($r['status_billing']=='N'){
												?>
												<button class="btn btn-danger btn-xs btnHapusLabhasil" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
												<?php
												}
											?>
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
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		
		<script type="text/javascript" src="assets/js/datatable_code_ajax.js"></script>
		<script type="text/javascript">
			$(function () {
				
				$('.btnEditLabhasil').click(function()
				{
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var id_pasien_order = $(this).attr('id_order');
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id+'&id_pasien_order='+id_pasien_order;
					$.ajax({
						type: 'POST',
						url: 'content/pasien/hasillab/aksi_hasillab_pasien.php?module=hasillab&act=edit',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_labhasil").html(msg);
						}
					});
					
				});
				
				$(".btnViewLabhasil").click(function(){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
					$.ajax({
						type: 'POST',
						url: 'view-pasien-hasillab',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_labhasil").html(msg);
						}
					});
					
				});
				
				
				$(".btnHapusLabhasil").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus hasillab ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var id_kunjungan=$("#id_kunjungan").val();
						var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-hasillab',
							data: dataString2,
							success: function(msg){
								$("#data_labhasil").html(msg);
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
	
	elseif ($module=='hasillab' AND $act=='edit'){
		
		$id_invoice_detail=$_POST['id'];
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		$id_pasien_order=$_POST['id_pasien_order'];
		
		?>
		<form id="edit_pasien_hasillab" class="form-horizontal" method="POST">
		<div class="card">
			<div class="card-header">
				<strong>Edit Hasil</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="id_laborder" id="id_laborder" value="<?php echo $id_pasien_order;?>">
						<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $_POST['id_pasien'];?>">
						<input type="hidden" name="id_kunjungan" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
						<input type="hidden" name="id_invoice_detail" id="id_kunjungan" value="<?php echo $id_invoice_detail;?>">						
					</div>
					
					<div class="col-md-12">
						<table class="table">
							<thead>
								<tr>
									<th>Jenis Pemeriksaan</th>
									<th>Detail</th>
									<th>Hasil</th>
									<th>Satuan</th>
									<th>Catatan</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT t.* from transaksi_invoice_detail t 
													WHERE t.id='$id_invoice_detail' and t.jenis <>'N' ");


								while($r=pg_fetch_array($tampil)){

									if($r['jenis']=='E'){
											
									$a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$r[id_detail]' order by d.id_detail ");

									$h=pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM billing_paket  
															WHERE id='$r[id_detail]' "));

									while($row=pg_fetch_assoc($a)){
												?>

											<?php	
												
											if($row['jenis']=='L'){
												$l=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
												$phd=pg_fetch_array(pg_query($dbconn,"SELECT nilai_hasil, catatan FROM pasien_hasillab_detail WHERE id_transaksi_invoice_detail='$id_invoice_detail' AND id_detail='$l[id]' AND jenis_pemeriksaan='S' AND id_lab_group is NULL "));
																						
												 echo"<tr>
													<td>$h[nama_paket]</td>
												 	<td>ST-$l[nama]</td>
												 	<td><input type='text' name='nilai_hasil_l#$l[id]' value='$phd[nilai_hasil]' class='form-control'>
													<input type='hidden' name='jenis#$l[id]' value='S' class='form-control'></td>
													<td>$l[satuan]</td>
													<td><input type='text' name='catatan_l#$l[id]' value='$phd[catatan]' class='form-control'></td>
													</tr>
												 ";	
												 									
												
											}
											elseif($row['jenis']=='LG'){
												$ag=pg_query($dbconn,"SELECT l.*, g.id_lab_analysis_group from lab_analysis_group_detail g
																	inner join lab_analysis l on l.id = g.id_lab_analysis where g.id_lab_analysis_group='$row[id_detail]'");

											

												while($lg=pg_fetch_assoc($ag))
												{
													echo 

												$phd=pg_fetch_array(pg_query($dbconn,"SELECT nilai_hasil, catatan FROM pasien_hasillab_detail WHERE id_transaksi_invoice_detail='$id_invoice_detail' AND id_detail='$lg[id]' AND jenis_pemeriksaan='S' AND id_lab_group='$lg[id_lab_analysis_group]' "));

																						
												 echo"<tr>
													<td>$h[nama_paket]</td>
												 	<td>MT-$lg[nama]</td>
												 	<td><input type='text' name='nilai_hasil_lg#$lg[id]' value='$phd[nilai_hasil]' class='form-control'>
													</td>
													<td>$lg[satuan]</td>
													<td><input type='text' name='catatan_lg#$lg[id]' value='$phd[catatan]' class='form-control'></td>
													</tr>
												 ";	
												 }												
											}
											else{

											}
																							
											}
																					
										}
										
										if($r['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis 
													WHERE id='$r[id_detail]'"));

											$phd=pg_fetch_array(pg_query($dbconn,"SELECT nilai_hasil, catatan FROM pasien_hasillab_detail WHERE id_transaksi_invoice_detail='$id_invoice_detail' AND id_detail='$a[id]' AND jenis_pemeriksaan='S'"));

											echo"<tr>
													<td>SINGLE TEST</td>
												 	<td>$a[nama]</td>
												 	<td><input type='text' name='nilai_hasil_s#$a[id]' value='$phd[nilai_hasil]' class='form-control'>
													</td>
													<td>$a[satuan]</td>
													<td><input type='text' name='catatan_s#$a[id]' value='$phd[catatan]' class='form-control'></td>
													</tr>
												 ";	
											
										}
										elseif($r['jenis']=='M'){
											$m=pg_query($dbconn,"SELECT l.* from lab_analysis_group_detail g
																	inner join lab_analysis l on l.id = g.id_lab_analysis where g.id_lab_analysis_group='$r[id_detail]'");

											
											while($a=pg_fetch_assoc($m))
											{

											$phd=pg_fetch_array(pg_query($dbconn,"SELECT nilai_hasil, catatan FROM pasien_hasillab_detail WHERE id_transaksi_invoice_detail='$id_invoice_detail' AND id_detail='$a[id]' AND jenis_pemeriksaan='S'"));



											echo"<tr>
													<td>MULTIPLE TEST</td>
												 	<td>$a[nama]</td>
												 	<td><input type='text' name='nilai_hasil_m#$a[id]' value='$phd[nilai_hasil]' class='form-control'>
													</td>
													<td>$a[satuan]</td>
													<td><input type='text' name='catatan_m#$a[id]' value='$phd[catatan]' class='form-control'></td>
													</tr>
												 ";	
											}
											
										}
										

		
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="button" class="btn btn-primary btn-sm" id="btnSimpanLabhasil">Simpan</button>
				<button type="button" class="btn btn-danger btn-sm" id="btnBatalLabhasil">Batal</button>
			</div>
		</div>
		</form>
		<script>
		$(function () {
			$('#btnSimpanLabhasil').click(function()
			{
				var data=$("#edit_pasien_hasillab").serialize();
				
				$.ajax({
					type: "POST",
					url: "aksi-edit-pasien-hasillab",
					data: data,
					success: function(data){

					$("#data_labhasil").html(data);
					}
				});
			});
		});	
		
		$(function () {
			$('#btnBatalLabhasil').click(function()
			{
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var id_pasien_order = $("#id_laborder").val();


				
				var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_pasien_order='+id_pasien_order;
				$.ajax({
					type: "POST",
					url: "data-pasien-hasillab",
					data: dataString2,
					cache: false,
					success: function(data){
						$("#data_labhasil").html(data);
					}
				});
			});
		});	
		</script>
		<?php
	}
	
	elseif ($module=='hasillab' AND $act=='update'){
		$jlh=pg_num_rows(pg_query($dbconn,"SELECT * FROM pasien_hasillab WHERE id_laborder='$_POST[id_laborder]' and id_invoice_detail='$_POST[id_invoice_detail]' "));

		$jh=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_hasillab WHERE id_laborder='$_POST[id_laborder]' and id_invoice_detail='$_POST[id_invoice_detail]' "));

		if($jlh==0){
			$result=pg_query($dbconn,"INSERT INTO pasien_hasillab (id_laborder, id_invoice_detail,  waktu_input, id_user, status_track, id_unit) VALUES ('$_POST[id_laborder]','$_POST[id_invoice_detail]',  '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', 'Y', '$_SESSION[id_units]') RETURNING id");
		
			$insert_row = pg_fetch_row($result);
			$insert_id = $insert_row[0];	
		
		$data=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_pasien_order='$_POST[id_laborder]' and id='$_POST[id_invoice_detail]'");
		
		while($d=pg_fetch_array($data)){

			///////////////////////////////////////////////////
					if($d['jenis']=='E'){
											
					$a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$d[id_detail]' order by d.id_detail ");


					while($row=pg_fetch_assoc($a)){
						?>
							<?php	
							if($row['jenis']=='L'){
								$id_d= $row[id_detail];
								$nilai_hasil=$_POST["nilai_hasil_l#$id_d"];
								$catatan=$_POST["catatan_l#$id_d"];
							
								pg_query($dbconn,"INSERT INTO pasien_hasillab_detail (id_hasillab, id_transaksi_invoice_detail, id_detail, id_pasien, id_kunjungan, nilai_hasil, catatan, id_unit, jenis_pemeriksaan) VALUES ('$insert_id', '$_POST[id_invoice_detail]', '$row[id_detail]',  '$d[id_pasien]', '$d[id_kunjungan]', '$nilai_hasil', '$catatan', '$_SESSION[id_units]','S')");

																					
							}
							elseif($row['jenis']=='LG'){
								$id_d= $row[id_detail];
								$m=pg_query($dbconn,"SELECT l.* from lab_analysis_group_detail g
													inner join lab_analysis l on l.id = g.id_lab_analysis 
													where g.id_lab_analysis_group='$row[id_detail]'");

											
							while($a=pg_fetch_assoc($m))
								{

								$nilai_hasil=$_POST["nilai_hasil_lg#$a[id]"];
								$catatan=$_POST["catatan_lg#$a[id]"];
							
								pg_query($dbconn,"INSERT INTO pasien_hasillab_detail (id_hasillab, id_transaksi_invoice_detail, id_detail, id_pasien, id_kunjungan, nilai_hasil, catatan, id_unit, jenis_pemeriksaan, id_lab_group) VALUES ('$insert_id', '$_POST[id_invoice_detail]', '$a[id]',  '$d[id_pasien]', '$d[id_kunjungan]', '$nilai_hasil', '$catatan', '$_SESSION[id_units]','S','$id_d')");

								}

							}
							else{
								
							}
							}	

						}		
							elseif($d['jenis']=='S'){
								$a=pg_query($dbconn,"SELECT * FROM lab_analysis 
														WHERE id='$d[id_detail]'");

								while($row=pg_fetch_assoc($a)){

									$id_d= $row[id];
									$nilai_hasil=$_POST["nilai_hasil_s#$id_d"];
									$catatan=$_POST["catatan_s#$id_d"];
								
									pg_query($dbconn,"INSERT INTO pasien_hasillab_detail (id_hasillab, id_transaksi_invoice_detail, id_detail, id_pasien, id_kunjungan, nilai_hasil, catatan, id_unit, jenis_pemeriksaan) VALUES ('$insert_id', '$_POST[id_invoice_detail]', '$d[id_detail]',  '$d[id_pasien]', '$d[id_kunjungan]', '$nilai_hasil', '$catatan', '$_SESSION[id_units]','S')");
								
								}	

							}
							elseif($d['jenis']=='M'){
								$id_d= $d[id_detail];
								$m=pg_query($dbconn,"SELECT l.* from lab_analysis_group_detail g
													inner join lab_analysis l on l.id = g.id_lab_analysis 
													where g.id_lab_analysis_group='$d[id_detail]'");

											
							while($a=pg_fetch_assoc($m))
								{

								$nilai_hasil=$_POST["nilai_hasil_m#$a[id]"];
								$catatan=$_POST["catatan_m#$a[id]"];
							
								pg_query($dbconn,"INSERT INTO pasien_hasillab_detail (id_hasillab, id_transaksi_invoice_detail, id_detail, id_pasien, id_kunjungan, nilai_hasil, catatan, id_unit, jenis_pemeriksaan) VALUES ('$insert_id', '$_POST[id_invoice_detail]', '$a[id]',  '$d[id_pasien]', '$d[id_kunjungan]', '$nilai_hasil', '$catatan', '$_SESSION[id_units]','S')");

							
								}

							}

						else{

						}		
			///////////////////////////////////////////////////
			}	
		}
		else{

		$insert_id = $jh[id];

		$data=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_pasien_order='$_POST[id_laborder]' and id='$_POST[id_invoice_detail]'");
		
		while($d=pg_fetch_array($data)){

			///////////////////////////////////////////////////
					if($d['jenis']=='E'){
											
					$a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$d[id_detail]' order by d.id_detail ");


					while($row=pg_fetch_assoc($a)){
							?>
								<?php	
								if($row['jenis']=='L'){
									$id_d= $row[id_detail];
									$nilai_hasil=$_POST["nilai_hasil_l#$id_d"];
									$catatan=$_POST["catatan_l#$id_d"];
								
									pg_query($dbconn,"UPDATE pasien_hasillab_detail set nilai_hasil ='$nilai_hasil', catatan='$catatan' WHERE id_transaksi_invoice_detail= '$_POST[id_invoice_detail]' 
													and id_detail='$id_d' and id_lab_group is NULL and jenis_pemeriksaan='S'");
												
								}
								elseif($row['jenis']=='LG'){
									$id_d= $row[id_detail];
									$m=pg_query($dbconn,"SELECT l.* from lab_analysis_group_detail g
													inner join lab_analysis l on l.id = g.id_lab_analysis 
													where g.id_lab_analysis_group='$row[id_detail]'");


												
								while($a=pg_fetch_assoc($m))
									{

									$nilai_hasil=$_POST["nilai_hasil_lg#$a[id]"];
									$catatan=$_POST["catatan_lg#$a[id]"];
									pg_query($dbconn,"UPDATE pasien_hasillab_detail set nilai_hasil ='$nilai_hasil', catatan='$catatan' WHERE id_transaksi_invoice_detail= '$_POST[id_invoice_detail]' 
													and id_detail='$a[id]' and id_lab_group='$id_d' and jenis_pemeriksaan='S'");

									}

								}
								else{
									
								}
							}	

						}		
						elseif($d['jenis']=='S'){
								$a=pg_query($dbconn,"SELECT * FROM lab_analysis 
														WHERE id='$d[id_detail]'");

								while($row=pg_fetch_assoc($a)){

									$id_d= $row[id];
									$nilai_hasil=$_POST["nilai_hasil_s#$id_d"];
									$catatan=$_POST["catatan_s#$id_d"];

									pg_query($dbconn,"UPDATE pasien_hasillab_detail set nilai_hasil ='$nilai_hasil', catatan='$catatan' WHERE id_transaksi_invoice_detail= '$_POST[id_invoice_detail]' 
													and id_detail='$id_d' and id_lab_group is NULL and jenis_pemeriksaan='S'");
								
									
								
								}	

							}
						elseif($d['jenis']=='M'){
								$id_d= $d[id_detail];
								$m=pg_query($dbconn,"SELECT l.* from lab_analysis_group_detail g
													inner join lab_analysis l on l.id = g.id_lab_analysis 
													where g.id_lab_analysis_group='$d[id_detail]'");

											
							while($a=pg_fetch_assoc($m))
								{

								$nilai_hasil=$_POST["nilai_hasil_m#$a[id]"];
								$catatan=$_POST["catatan_m#$a[id]"];

									pg_query($dbconn,"UPDATE pasien_hasillab_detail set nilai_hasil ='$nilai_hasil', catatan='$catatan' WHERE id_transaksi_invoice_detail= '$_POST[id_invoice_detail]' 
													and id_detail='$a[id]' and jenis_pemeriksaan='S'");
							
							
								}

							}

						else{

						}		
			}	


		}
		
		$id_pasien=$_POST['id_pasien'];
		?>
		
		<div class="card">
			<div class="card-header">
				<strong>Data Hasil Lab</strong>
				<span class="pull-right">
				</span>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<table class="table">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Jenis Pemeriksaan</th>
									<th>Detail</th>
									<th>No RM</th>
									<th>Status</th>
									<th width="100px">#</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT t.* from transaksi_invoice_detail t
									INNER JOIN pasien_order p on p.id=t.id_pasien_order and p.id_pasien=t.id_pasien
									WHERE p.id_pasien='$id_pasien' and t.id_pasien='$id_pasien' 
																   and t.id_kunjungan='$_POST[id_kunjungan]' and t.jenis <>'N'");
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);

									 if($r['jenis']=='E'){
											
											$a=pg_fetch_array(pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$r[id_detail]' order by d.id_detail "));
											$jenis="MCU";
											$nama_transaksi=$a[nama_paket];										
											
										}
										
										if($r['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
											$jenis= "SINGLE TEST";								
											$nama_transaksi=$a[nama];
											
											
										}
										elseif($r['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
											$jenis="Multiple Test";
											$nama_transaksi=$a[nama];
											
										}
									
										if($r['status_order']==3){
											$status="<button class='btn btn-xs btn-success' title='hasil'><i class='icon-check'></i></button>";
										
										}
										else{
											$status="<button class='btn btn-xs btn-warning' title='proses'>-</button>";
										}
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $jenis; ?></td>
										<td><?php echo $nama_transaksi;?></td>
										<td><?php echo $_POST[id];?></td>
										<td><?php echo $status;?></td>
										<td>

											
											<button class="btn btn-primary btn-xs btnEditLabhasil" id_order="<?php echo $r[id_pasien_order];?>" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
											<button class="btn btn-info btn-xs btnViewLabhasil" id="<?php echo $r['id'];?>"><i class="icon-eye"></i></button>
											<?php
												if($r['status_billing']=='N'){
												?>
												<button class="btn btn-danger btn-xs btnHapusLabhasil" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
												<?php
												}
											?>
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
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		
		<script type="text/javascript" src="assets/js/datatable_code_ajax.js"></script>
		<script type="text/javascript">
			$(function () {
				
				$('.btnEditLabhasil').click(function()
				{
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var id_pasien_order = $(this).attr('id_order');
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id+'&id_pasien_order='+id_pasien_order;

					$.ajax({
						type: 'POST',
						url: 'content/pasien/hasillab/aksi_hasillab_pasien.php?module=hasillab&act=edit',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_labhasil").html(msg);
						}
					});
					
				});
				
				$(".btnViewLabhasil").click(function(){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
					$.ajax({
						type: 'POST',
						url: 'view-pasien-hasillab',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_labhasil").html(msg);
						}
					});
					
				});
							
				$(".btnHapusLabhasil").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus hasillab ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var id_kunjungan=$("#id_kunjungan").val();
						var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-hasillab',
							data: dataString2,
							success: function(msg){
								$("#data_labhasil").html(msg);
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


	elseif ($module=='hasillab' AND $act=='view'){
		$id_laborder=$_POST['id'];
		
		$po=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id='$_POST[id]'"));
		$id_pasien_hasillab=$po['id_pasien_hasillab'];
		$id_kunjungan=$po['id_kunjungan'];
		$id_pasien=$po['id_pasien'];
		
		$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$po[id_refered_by]'"));
		$nama_perujuk=$a['nama'];
		
		$ph=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_hasillab WHERE id='$id_pasien_hasillab'"));
		
		$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_unit_lab WHERE id='$ph[id_unit_lab]'"));
		$nama_laboratium=$a['nama'];
		
		$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$ph[id_priority]'"));
		$nama_prioritas=$a['nama'];
	?>
	<div class="card">
		<div class="card-header">
			<strong>Detail Hasil Lab</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<tr>
							<td width="150px">Dari</td><td width="10px">:</td><td><?php echo $nama_laboratium;?></td>
						</tr>
						<tr>
							<td>Prioritas</td><td>:</td><td><?php echo $nama_prioritas;?></td>
						</tr>
						<tr>
							<td>Analisis</td><td>:</td>
							<td>
								<table class="table">
								<thead>
									<tr>
										<th>No.</th>
										<th>Group</th>
										<th>Analisis</th>
										<th>Hasil</th>
										<th>Catatan</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$no=1;
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder_detail WHERE id_lab_order='$id_laborder'");
								while($r=pg_fetch_array($tampil)){
									if($r['id_lab_analysis_group']!=NULL){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama FROM lab_analysis_group WHERE id='$r[id_lab_analysis_group]'"));
										?>
										<tr>
											<td width="20px"><?php echo $no;?></td>
											<td colspan="3"><?php echo $a['nama'];?></td>
										</tr>
										<?php
										$lab_analysis=pg_query($dbconn,"SELECT a.id, a.nama, a.satuan FROM lab_analysis a, lab_analysis_group_detail b WHERE a.id=b.id_lab_analysis AND b.id_lab_analysis_group='$r[id_lab_analysis_group]'");
										while($l=pg_fetch_array($lab_analysis)){
											$phd=pg_fetch_array(pg_query($dbconn,"SELECT nilai_hasil, catatan FROM pasien_hasillab_detail WHERE id_hasillab='$id_pasien_hasillab' AND id_lab_analysis='$l[id]' AND id_hasillab='$id_pasien_hasillab' AND id_lab_analysis_group='$r[id_lab_analysis_group]'"));
											echo"
											<tr>
												<td></td>
												<td></td>
												<td>$l[nama]</td>
												<td>$phd[nilai_hasil] $l[satuan]</td>
												<td>$phd[catatan]</td>
											</tr>
											";
										}
									}
									else{
										$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama, satuan FROM lab_analysis WHERE id='$r[id_lab_analysis]'"));
										$phd=pg_fetch_array(pg_query($dbconn,"SELECT nilai_hasil, catatan FROM pasien_hasillab_detail WHERE id_hasillab='$id_pasien_hasillab' AND id_lab_analysis='$a[id]' AND id_hasillab='$id_pasien_hasillab'"));
										
										?>
										<tr>
											<td width="20px"><?php echo $no;?></td>
											<td></td>
											<td><?php echo $a['nama'];?></td>
											<td><?php echo "$phd[nilai_hasil] $a[satuan]";?></td>
											<td><?php echo "$phd[catatan]";?></td>
											
										</tr>
										<?php
									}
									$no++;
								}
								?>
								</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>Dirujuk Oleh</td><td>:</td><td><?php echo $nama_perujuk;?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type="button" class="btn btn-default btn-sm" id="btnBatalLaborder">Kembali</button>
		</div>
	</div>	
	<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
	<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
	<script>
		$('#btnBatalLaborder').click(function()
		{
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
			$.ajax({
				type: "POST",
				url: "data-pasien-hasillab",
				data: dataString2,
				cache: false,
				success: function(data){
					$("#data_labhasil").html(data);
				}
			});
		});
		</script>
	<?php
	}
	pg_close($dbconn);
}
?>