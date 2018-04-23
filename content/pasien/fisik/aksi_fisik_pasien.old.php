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
	
	$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
	if ($module=='fisik' AND $act=='data_fisik'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Pemeriksaan Fisik</strong>
			<span class="pull-right">
				<?php
				if($id_kunjungan!=''){
				?>
				<button type="button" class="btn btn-primary btn-xs btnTambah" title="Tambah">Tambah</button>
				<?php
				}
				?>
			</span>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<p class="title-dark">Data</p>
					<table class="table">
						<thead>
							<tr>
								<th width="30px">No.</th>
								<th width="140px">Tanggal/Jam</th>
								<th>Kunjungan</th>
								<th>Keadaan Umum</th>
								<th width="80px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_fisik WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal=DateToIndo2($a[0]);
									$jam=$a[1];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT a.detail_segmen, a.id_paket, b.keterangan FROM antrian a, segmen b WHERE a.id_segmen=b.id AND a.id_kunjungan='$r[id_kunjungan]' AND a.status_aktif='Y'"));
									if($a['id_paket']!=''){
										$b=pg_fetch_array(pg_query($dbconn,"SELECT nama_paket FROM billing_paket WHERE id='$a[id_paket]'"));
										$kunjungan="$a[keterangan]-$b[nama_paket]";
									}
									else{
										if($a['detail_segmen']!=''){
											$kunjungan="$a[keterangan]-$a[detail_segmen]";
										}
										else{
											$kunjungan="$a[keterangan]";
										}
									}
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><a href="#" id="<?php echo $r['id'];?>" class="btnView"><?php echo "$tanggal/$jam";?></a></td>
										<td><?php echo $kunjungan;?></td>
										<td><?php echo $r['keterangan'];?></td>
										<td>
											<button type="button" class="btn btn-info btn-xs btnEdit" id="<?php echo $r['id'];?>"title="Edit"><i class="icon-note"></i></button>
											<button type="button" class="btn btn-danger btn-xs btnHapus" id="<?php echo $r['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
										</td>
									</tr>
									<?php
									$no++;
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(function () {
				$(".btnTambah").click(function(){
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
					$.ajax({
						type: 'POST',
						url: 'form-tambah-pasien-fisik',
						data: dataString2,
						success: function(msg){
							$("#data_fisik").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-fisik',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_fisik").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus fisik ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-fisik',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_fisik").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-fisik',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_fisik").html(msg);
								alert("fisik berhasil dihapus");
							}
						});
					}
					else{
						return false;
					}
				});
				
				$(".btnView").click(function(){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'view-pasien-fisik',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_fisik").html(msg);
						}
					});
				});
			});
			</script>
		<?php
	}
	
	elseif ($module=='fisik' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_fisik" class="form-horizontal" action="aksi-tambah-pasien-fisik" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Pemeriksaan Fisik</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<label class="col-md-3 form-control-label">Keadaan Umum</label>
						<div class="col-md-9">
							<textarea name="keterangan" class="form-control" placeholder="Catatan Keadaan Umum"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<p class="title-dark">Pemeriksaan Fisik</p>
					<div class="padding-20">
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM fisik");
						$no=1;
						while($r=pg_fetch_array($tampil)){
							?>
							<div class="form-group row">
								<label class="col-md-2 form-control-label">
									<input type="checkbox" name="checked[]" value="<?php echo $r['id'];?>" checked> <?php echo "$no. $r[nama]";?>
								</label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="nilai#<?php echo $r['id'];?>" placeholder="Nilai">
								</div>
								<div class="col-md-1">
									<?php echo $r['satuan'];?>
								</div>
								<div class="col-md-4">
									<input type="text" class="form-control" name="keterangan#<?php echo $r['id'];?>" placeholder="Keterangan">
								</div>
							</div>
							<?php
							$no++;
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary btn-sm btnSimpan">Simpan</button>
			<button type="button" class="btn btn-danger btn-sm btnBatal">Batal</button>
		</div>
	</form>
		<script type="text/javascript">
		$(document).ready(function (e) {
			$('#tambah_pasien_fisik').on('submit',(function(e) {
				e.preventDefault();
				var formData = new FormData(this);
				var id_pasien=$("#id_pasien").val();
				
				var dataString2 = 'id_pasien='+id_pasien;
				$(".btnSimpan").html("Sedang menyimpan..");
				$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					cache:false,
					contentType: false,
					processData: false,
					success:function(data){
						console.log("success");
						console.log(data);
						//$("#data_pengukuran").html(data);
						//(".btnSimpan").html("Simpan");
					},
					error: function(data){
						console.log("error");
						console.log(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'data-pasien-fisik',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_fisik").html(msg);
						alert('Data berhasil disimpan');
					}
				});
			}));
		});
		
		$(function () {
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			$(".btnBatal").click(function(){
				$.ajax({
					type: 'POST',
					url: 'data-pasien-fisik',
					data: dataString2,
					success: function(msg){
						$("#data_fisik").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='fisik' AND $act=='input'){
		/*fisik*/
		$result=pg_query($dbconn,"INSERT INTO pasien_fisik (id_kunjungan, id_pasien, id_unit, waktu_input, id_user, keterangan, status_hapus) VALUES ('$_POST[id_kunjungan]', '$_POST[id_pasien]', '$_SESSION[id_units]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[keterangan]', 'N') RETURNING id");
		
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		
		foreach($_POST['checked'] as $key => $value){
			$id=$value;
			$nilai=$_POST['nilai#'.$value];
			$keterangan=$_POST['keterangan#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_fisik_detail (id_pasien_fisik, nilai, keterangan, id_fisik) VALUES ('$insert_id', '$nilai', '$keterangan', '$id')");
		}
	}
	
	elseif ($module=='fisik' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_fisik WHERE id='$_POST[id]'"));
		$id_fisik=$d['id'];
		?>
		<form id="edit_pasien_fisik" class="form-horizontal" action="aksi-edit-pasien-fisik" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_fisik">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Pemeriksaan Fisik</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group row">
							<label class="col-md-3 form-control-label">Keadaan Umum</label>
							<div class="col-md-9">
								<textarea name="keterangan" class="form-control" placeholder="Catatan Keadaan Umum"><?php echo $d['keterangan'];?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<p class="title-dark">Pemeriksaan Fisik</p>
						<div class="padding-20">
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM fisik");
							$no=1;
							while($r=pg_fetch_array($tampil)){
								$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_fisik_detail WHERE id_pasien_fisik='$id_fisik' AND id_fisik='$r[id]'"));
								?>
								<div class="form-group row">
									<label class="col-md-2 form-control-label">
										<input type="checkbox" name="checked[]" value="<?php echo $r['id'];?>" <?php if($p['id']!=''){echo "checked";}?>> <?php echo "$no. $r[nama]";?>
									</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="nilai#<?php echo $r['id'];?>" placeholder="Nilai" value="<?php echo $p['nilai'];?>">
									</div>
									<div class="col-md-1">
										<?php echo $r['satuan'];?>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control" name="keterangan#<?php echo $r['id'];?>" placeholder="Keterangan" value="<?php echo $p['keterangan'];?>">
									</div>
								</div>
								<?php
								$no++;
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary btn-sm btnSimpan">Simpan</button>
				<button type="button" class="btn btn-danger btn-sm btnBatal">Batal</button>
			</div>
		</form>
		
		<script type="text/javascript">
			$(document).ready(function (e) {
				$('#edit_pasien_fisik').on('submit',(function(e) {
					e.preventDefault();
					var formData = new FormData(this);
					var id_pasien=$("#id_pasien").val();
					
					var dataString2 = 'id_pasien='+id_pasien;
					$(".btnSimpan").html("Sedang menyimpan..");
					$.ajax({
						type:'POST',
						url: $(this).attr('action'),
						data:formData,
						cache:false,
						contentType: false,
						processData: false,
						success:function(data){
							console.log("success");
							console.log(data);
							//$("#data_pengukuran").html(data);
							//(".btnSimpan").html("Simpan");
						},
						error: function(data){
							console.log("error");
							console.log(data);
						}
					});
					
					$.ajax({
						type: 'POST',
						url: 'data-pasien-fisik',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_fisik").html(msg);
							alert('Data berhasil disimpan');
						}
					});
				}));
			});
			$(function () {
				var id_pasien=$("#id_pasien").val();
				var dataString2 = 'id_pasien='+id_pasien;
				$(".btnBatal").click(function(){
					$.ajax({
						type: 'POST',
						url: 'data-pasien-fisik',
						data: dataString2,
						success: function(msg){
							$("#data_fisik").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='fisik' AND $act=='update'){
		$id_fisik=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_fisik SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', keterangan='$_POST[keterangan]' WHERE id='$id_fisik'");
		
		/*keluhan saat ini*/
		pg_query($dbconn,"DELETE FROM pasien_fisik_detail WHERE id_pasien_fisik='$id_fisik'");
		foreach($_POST['checked'] as $key => $value){
			$id=$value;
			$nilai=$_POST['nilai#'.$value];
			$keterangan=$_POST['keterangan#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_fisik_detail (id_pasien_fisik, nilai, keterangan, id_fisik) VALUES ('$id_fisik', '$nilai', '$keterangan', '$id')");
		}
	}
	
	elseif ($module=='fisik' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_fisik SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	elseif ($module=='fisik' AND $act=='view'){
		$r=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_fisik WHERE id='$_POST[id]'"));
		$id_fisik=$r['id'];
		$a=explode(" ",$r['waktu_input']);
		$tanggal=DateToIndo2($a[0]);
		$jam=$a[1];
		
		$a=pg_fetch_array(pg_query($dbconn,"SELECT a.detail_segmen, a.id_paket, b.keterangan FROM antrian a, segmen b WHERE a.id_segmen=b.id AND a.id_kunjungan='$r[id_kunjungan]' AND a.status_aktif='Y'"));
		if($a['id_paket']!=''){
			$b=pg_fetch_array(pg_query($dbconn,"SELECT nama_paket FROM billing_paket WHERE id='$a[id_paket]'"));
			$kunjungan="$a[keterangan]-$b[nama_paket]";
		}
		else{
			if($a['detail_segmen']!=''){
				$kunjungan="$a[keterangan]-$a[detail_segmen]";
			}
			else{
				$kunjungan="$a[keterangan]";
			}
		}
		?>
		<input type="hidden" id="id_pasien" value="<?php echo $r['id_pasien'];?>">
		<div class="card-header">
			<strong>View Pemeriksaan Fisik</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<p class="title-dark">Detail</p>
					<div class="padding-20">
						<table class="table">
							<tr>
								<td width="150px">Tanggal/Jam</td>
								<td width="20px">:</td>
								<td><?php echo "$tanggal $jam";?></td>
							</tr>
							<tr>
								<td>Kunjungan</td>
								<td>:</td>
								<td><?php echo $kunjungan;?></td>
							</tr>
							<tr>
								<td>Keadaan Umum</td>
								<td>:</td>
								<td><?php echo $r['keterangan'];?></td>
							</tr>
						</table>
					</div>
					
					<p class="title-dark">Pemeriksaan Fisik</p>
					<div class="padding-20">
						<table class="table">
							<thead class="text-center">
								<th width="50px">No.</th>
								<th>Item Pemeriksaan</th>
								<th>Hasil</th>
								<th>Keterangan</th>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM fisik");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_fisik_detail WHERE id_pasien_fisik='$id_fisik' AND id_fisik='$r[id]'"));
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo $r['nama'];?></td>
										<td><?php echo "$p[nilai] $r[satuan]";?></td>
										<td><?php echo $p['keterangan'];?></td>
									</tr>
									<?php
									$no++;
								}
								?>	
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type="button" class="btn btn-primary btn-sm btnBatal">Kembali</button>
		</div>
		<script type="text/javascript">
			$(function () {
				var id_pasien=$("#id_pasien").val();
				var dataString2 = 'id_pasien='+id_pasien;
				$(".btnBatal").click(function(){
					$.ajax({
						type: 'POST',
						url: 'data-pasien-fisik',
						data: dataString2,
						success: function(msg){
							$("#data_fisik").html(msg);
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