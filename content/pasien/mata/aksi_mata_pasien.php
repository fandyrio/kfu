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
	if ($module=='mata' AND $act=='data_mata'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Pemeriksaan Mata</strong>
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
					<table class="table table-bordered">
						<thead class="text-center">
							<tr>
								<th rowspan="3" width="30px">No.</th>
								<th rowspan="3" width="140px">Tanggal/Jam</th>
								<th rowspan="3" >Kunjungan</th>
								<th colspan="9">Hasil</th>
								<th rowspan="3">Keterangan</th>
								<th rowspan="3" width="80px">#</th>
							</tr>
							<tr>
								<th rowspan="2">Buta Warna</th>
								<th rowspan="2">Kacamata</th>
								<th colspan="3">Visus Tanpa Kacamata</th>
								<th colspan="3">Visus Dengan Kacamata</th>
								<th rowspan="2">Kelainan Mata Lain</th>
							</tr>
							<tr>
								<th>OD</th>
								<th>OS</th>
								<th>ODS</th>
								<th>OD</th>
								<th>OS</th>
								<th>ODS</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_mata WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
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
									
									if($r['butawarna']==1){
										$butawarna="Tidak";
									}
									elseif($r['butawarna']==2){
										$butawarna="Parsial";
									}
									else{
										$butawarna="Total";
									}
									
									if($r['kacamata']=='N'){
										$kacamata="Tidak";
									}
									else{
										$kacamata="Ya";
									}
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo "$tanggal/$jam";?></td>
										<td><?php echo $kunjungan;?></td>
										<td><?php echo $butawarna;?></td>
										<td><?php echo $kacamata;?></td>
										<td><?php echo $r['visus_a_1'];?></td>
										<td><?php echo $r['visus_a_2'];?></td>
										<td><?php echo $r['visus_a_3'];?></td>
										<td><?php echo $r['visus_b_1'];?></td>
										<td><?php echo $r['visus_b_2'];?></td>
										<td><?php echo $r['visus_b_3'];?></td>
										<td><?php echo $r['kelainan'];?></td>
										<td><?php echo $r['keterangan'];?></td>
										<td>
											<button type="button" class="btn btn-info btn-xs btnEdit" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
											<button type="button" class="btn btn-danger btn-xs btnHapus" id="<?php echo $r['id'];?>"><i class="icon-trash" title="Hapus"></i></button>
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
						url: 'form-tambah-pasien-mata',
						data: dataString2,
						success: function(msg){
							$("#data_mata").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-mata',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_mata").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus mata ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-mata',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_mata").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-mata',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_mata").html(msg);
								alert("mata berhasil dihapus");
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
	
	elseif ($module=='mata' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_mata" class="form-horizontal" action="aksi-tambah-pasien-mata" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Pemeriksaan Mata</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<p class="title-dark">Pemeriksaan Mata</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								1. Buta Warna
							</label>
							<div class="col-md-2">
								<select name="butawarna" class="form-control">
									<option value="1">Tidak</option>
									<option value="2">Parsial</option>
									<option value="3">Total</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								2. Kacamata
							</label>
							<div class="col-md-2">
								<select name="kacamata" class="form-control">
									<option value="N">Tidak</option>
									<option value="Y">Ya</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								3. Visus (tanpa kacamata)
							</label>
							<div class="col-md-6">
								<table class="table table-bordered">
									<tr>
										<td class="text-center">OD</td>
										<td class="text-center">OS</td>
										<td class="text-center">ODS</td>
									</tr>
									<tr>
										<td><input type="text" class="form-control" name="visus_a_1"></td>
										<td><input type="text" class="form-control" name="visus_a_2"></td>
										<td><input type="text" class="form-control" name="visus_a_3"></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								4. Visus (dengan kacamata)
							</label>
							<div class="col-md-6">
								<table class="table table-bordered">
									<tr>
										<td class="text-center">OD</td>
										<td class="text-center">OS</td>
										<td class="text-center">ODS</td>
									</tr>
									<tr>
										<td><input type="text" class="form-control" name="visus_b_1"></td>
										<td><input type="text" class="form-control" name="visus_b_2"></td>
										<td><input type="text" class="form-control" name="visus_b_3"></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								5. Kelainan Mata Lain
							</label>
							<div class="col-md-6">
								<input type="text" name="kelainan" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								6. Keterangan/Catatan
							</label>
							<div class="col-md-6">
								<textarea name="keterangan" class="form-control"></textarea>
							</div>
						</div>
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
			$('#tambah_pasien_mata').on('submit',(function(e) {
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
					url: 'data-pasien-mata',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_mata").html(msg);
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
					url: 'data-pasien-mata',
					data: dataString2,
					success: function(msg){
						$("#data_mata").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='mata' AND $act=='input'){
		/*mata*/
		pg_query($dbconn,"INSERT INTO pasien_mata (id_kunjungan, id_pasien, id_unit, id_user, waktu_input, butawarna, visus_a_1, visus_a_2, visus_a_3, visus_b_1, visus_b_2, visus_b_3, kelainan, keterangan, kacamata, status_hapus) VALUES ('$_POST[id_kunjungan]', '$_POST[id_pasien]', '$_SESSION[id_units]', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$_POST[butawarna]', '$_POST[visus_a_1]', '$_POST[visus_a_2]', '$_POST[visus_a_3]', '$_POST[visus_b_1]', '$_POST[visus_b_2]', '$_POST[visus_b_3]', '$_POST[kelainan]', '$_POST[keterangan]', '$_POST[kacamata]', 'N')");
		
	}
	
	elseif ($module=='mata' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_mata WHERE id='$_POST[id]'"));
		$id_mata=$d['id'];
		?>
		<form id="edit_pasien_mata" class="form-horizontal" action="aksi-edit-pasien-mata" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_mata">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Pemeriksaan Mata</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<p class="title-dark">Pemeriksaan Mata</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									1. Buta Warna
								</label>
								<div class="col-md-2">
									<select name="butawarna" class="form-control">
										<option value="1" <?php if($d['butawarna']==1){echo "selected";}?>>Tidak</option>
										<option value="2" <?php if($d['butawarna']==2){echo "selected";}?>>Parsial</option>
										<option value="3" <?php if($d['butawarna']==3){echo "selected";}?>>Total</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									2. Kacamata
								</label>
								<div class="col-md-2">
									<select name="kacamata" class="form-control">
										<option value="N" <?php if($d['kacamata']=='N'){echo "selected";}?>>Tidak</option>
										<option value="Y" <?php if($d['kacamata']=='Y'){echo "selected";}?>>Ya</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									3. Visus (tanpa kacamata)
								</label>
								<div class="col-md-6">
									<table class="table table-bordered">
										<tr>
											<td class="text-center">OD</td>
											<td class="text-center">OS</td>
											<td class="text-center">ODS</td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" name="visus_a_1" value="<?php echo $d['visus_a_1'];?>"></td>
											<td><input type="text" class="form-control" name="visus_a_2" value="<?php echo $d['visus_a_2'];?>"></td>
											<td><input type="text" class="form-control" name="visus_a_3" value="<?php echo $d['visus_a_3'];?>"></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									4. Visus (dengan kacamata)
								</label>
								<div class="col-md-6">
									<table class="table table-bordered">
										<tr>
											<td class="text-center">OD</td>
											<td class="text-center">OS</td>
											<td class="text-center">ODS</td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" name="visus_b_1" value="<?php echo $d['visus_b_1'];?>"></td>
											<td><input type="text" class="form-control" name="visus_b_2" value="<?php echo $d['visus_b_2'];?>"></td>
											<td><input type="text" class="form-control" name="visus_b_3" value="<?php echo $d['visus_b_3'];?>"></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									5. Kelainan Mata Lain
								</label>
								<div class="col-md-6">
									<input type="text" name="kelainan" class="form-control" value="<?php echo $d['kelainan'];?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									6. Keterangan/Catatan
								</label>
								<div class="col-md-6">
									<textarea name="keterangan" class="form-control"><?php echo $d['keterangan'];?></textarea>
								</div>
							</div>
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
				$('#edit_pasien_mata').on('submit',(function(e) {
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
						url: 'data-pasien-mata',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_mata").html(msg);
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
						url: 'data-pasien-mata',
						data: dataString2,
						success: function(msg){
							$("#data_mata").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='mata' AND $act=='update'){
		$id_mata=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_mata SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', butawarna='$_POST[butawarna]', visus_a_1='$_POST[visus_a_1]', visus_a_2='$_POST[visus_a_2]', visus_a_3='$_POST[visus_a_3]', visus_b_1='$_POST[visus_b_1]', visus_b_2='$_POST[visus_b_2]', visus_b_3='$_POST[visus_b_3]', kelainan='$_POST[kelainan]', kacamata='$_POST[kacamata]', keterangan='$_POST[keterangan]' WHERE id='$id_mata'");
	}
	
	elseif ($module=='mata' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_mata SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	pg_close($dbconn);
}
?>