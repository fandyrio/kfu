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
	if ($module=='extremitas' AND $act=='data_extremitas'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Pemeriksaan Extremitas</strong>
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
								<th>Keterangan</th>
								<th width="80px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_extremitas WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
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
						url: 'form-tambah-pasien-extremitas',
						data: dataString2,
						success: function(msg){
							$("#data_extremitas").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-extremitas',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_extremitas").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus extremitas ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-extremitas',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_extremitas").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-extremitas',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_extremitas").html(msg);
								alert("extremitas berhasil dihapus");
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
						url: 'view-pasien-extremitas',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_extremitas").html(msg);
						}
					});
				});
			});
			</script>
		<?php
	}
	
	elseif ($module=='extremitas' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_extremitas" class="form-horizontal" action="aksi-tambah-pasien-extremitas" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Pemeriksaan Extremitas</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<label class="col-md-3 form-control-label">Keterangan</label>
						<div class="col-md-9">
							<textarea name="keterangan" class="form-control" placeholder="Keterangan/Catatan"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<p class="title-dark">Pemeriksaan Extremitas</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-2 form-control-label">1. Tulang/Sendi</label>
							<div class="col-md-2">
								<select name="extremitas1_hasil" class="form-control">
									<option value="1">Normal</option>
									<option value="2">Tidak Normal</option>
								</select>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="extremitas1_keterangan" placeholder="Keterangan">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">2. Otot-otot/Tonus</label>
							<div class="col-md-2">
								<select name="extremitas2_hasil" class="form-control">
									<option value="1">Normal</option>
									<option value="2">Tidak Normal</option>
								</select>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="extremitas2_keterangan" placeholder="Keterangan">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">3. Jari-jari/Kuku</label>
							<div class="col-md-2">
								<select name="extremitas3_hasil" class="form-control">
									<option value="1">Normal</option>
									<option value="2">Tidak Normal</option>
								</select>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="extremitas3_keterangan" placeholder="Keterangan">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">4. Tangan</label>
							<div class="col-md-2">
								<select name="extremitas4_hasil" class="form-control">
									<option value="1">Normal</option>
									<option value="2">Tidak Normal</option>
								</select>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="extremitas4_keterangan" placeholder="Keterangan">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">5. Kaki</label>
							<div class="col-md-2">
								<select name="extremitas5_hasil" class="form-control">
									<option value="1">Normal</option>
									<option value="2">Tidak Normal</option>
								</select>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="extremitas5_keterangan" placeholder="Keterangan">
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
			$('#tambah_pasien_extremitas').on('submit',(function(e) {
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
					url: 'data-pasien-extremitas',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_extremitas").html(msg);
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
					url: 'data-pasien-extremitas',
					data: dataString2,
					success: function(msg){
						$("#data_extremitas").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='extremitas' AND $act=='input'){
		/*extremitas*/
		pg_query($dbconn,"INSERT INTO pasien_extremitas (id_pasien, id_kunjungan, id_unit, waktu_input, status_hapus, id_user, extremitas1_hasil, extremitas1_keterangan, extremitas2_hasil, extremitas2_keterangan, extremitas3_hasil, extremitas3_keterangan, extremitas4_hasil, extremitas4_keterangan, extremitas5_hasil, extremitas5_keterangan, keterangan) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', '$_SESSION[id_units]', '$tgl_sekarang $jam_sekarang', 'N', '$_SESSION[login_user]', '$_POST[extremitas1_hasil]', '$_POST[extremitas1_keterangan]', '$_POST[extremitas2_hasil]', '$_POST[extremitas2_keterangan]', '$_POST[extremitas3_hasil]', '$_POST[extremitas3_keterangan]', '$_POST[extremitas4_hasil]', '$_POST[extremitas4_keterangan]', '$_POST[extremitas5_hasil]', '$_POST[extremitas5_keterangan]', '$_POST[keterangan]')");
		
	}
	
	elseif ($module=='extremitas' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_extremitas WHERE id='$_POST[id]'"));
		$id_extremitas=$d['id'];
		?>
		<form id="edit_pasien_extremitas" class="form-horizontal" action="aksi-edit-pasien-extremitas" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_extremitas">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Pemeriksaan Extremitas</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group row">
							<label class="col-md-3 form-control-label">Keterangan</label>
							<div class="col-md-9">
								<textarea name="keterangan" class="form-control" placeholder="Keterangan/Catatan"><?php echo $d['keterangan'];?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<p class="title-dark">Pemeriksaan Extremitas</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-2 form-control-label">1. Tulang/Sendi</label>
								<div class="col-md-2">
									<select name="extremitas1_hasil" class="form-control">
										<option value="1" <?php if($d['extremitas1_hasil']==1) echo"selected";?>>Normal</option>
										<option value="2" <?php if($d['extremitas1_hasil']==2) echo"selected";?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="extremitas1_keterangan" placeholder="Keterangan" value="<?php echo $d['extremitas1_keterangan'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">2. Otot-otot/Tonus</label>
								<div class="col-md-2">
									<select name="extremitas2_hasil" class="form-control">
										<option value="1" <?php if($d['extremitas2_hasil']==1) echo"selected";?>>Normal</option>
										<option value="2" <?php if($d['extremitas2_hasil']==2) echo"selected";?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="extremitas2_keterangan" placeholder="Keterangan"  value="<?php echo $d['extremitas2_keterangan'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">3. Jari-jari/Kuku</label>
								<div class="col-md-2">
									<select name="extremitas3_hasil" class="form-control">
										<option value="1" <?php if($d['extremitas3_hasil']==1) echo"selected";?>>Normal</option>
										<option value="2" <?php if($d['extremitas3_hasil']==2) echo"selected";?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="extremitas3_keterangan" placeholder="Keterangan" value="<?php echo $d['extremitas3_keterangan'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">4. Tangan</label>
								<div class="col-md-2">
									<select name="extremitas4_hasil" class="form-control">
										<option value="1" <?php if($d['extremitas4_hasil']==1) echo"selected";?>>Normal</option>
										<option value="2" <?php if($d['extremitas4_hasil']==2) echo"selected";?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="extremitas4_keterangan" placeholder="Keterangan" value="<?php echo $d['extremitas4_keterangan'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">5. Kaki</label>
								<div class="col-md-2">
									<select name="extremitas5_hasil" class="form-control">
										<option value="1" <?php if($d['extremitas5_hasil']==1) echo"selected";?>>Normal</option>
										<option value="2" <?php if($d['extremitas5_hasil']==2) echo"selected";?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="extremitas5_keterangan" placeholder="Keterangan" value="<?php echo $d['extremitas5_keterangan'];?>">
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
				$('#edit_pasien_extremitas').on('submit',(function(e) {
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
						url: 'data-pasien-extremitas',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_extremitas").html(msg);
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
						url: 'data-pasien-extremitas',
						data: dataString2,
						success: function(msg){
							$("#data_extremitas").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='extremitas' AND $act=='update'){
		$id_extremitas=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_extremitas SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', keterangan='$_POST[keterangan]', extremitas1_hasil='$_POST[extremitas1_hasil]', extremitas1_keterangan='$_POST[extremitas1_keterangan]', extremitas2_hasil='$_POST[extremitas2_hasil]', extremitas2_keterangan='$_POST[extremitas2_keterangan]', extremitas3_hasil='$_POST[extremitas3_hasil]', extremitas3_keterangan='$_POST[extremitas3_keterangan]', extremitas4_hasil='$_POST[extremitas4_hasil]', extremitas4_keterangan='$_POST[extremitas4_keterangan]', extremitas5_hasil='$_POST[extremitas5_hasil]', extremitas5_keterangan='$_POST[extremitas5_keterangan]' WHERE id='$id_extremitas'");
		
	}
	
	elseif ($module=='extremitas' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_extremitas SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	elseif ($module=='extremitas' AND $act=='view'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_extremitas WHERE id='$_POST[id]'"));
		$id_extremitas=$d['id'];
		$a=explode(" ",$d['waktu_input']);
		$tanggal=DateToIndo2($a[0]);
		$jam=$a[1];
		
		$a=pg_fetch_array(pg_query($dbconn,"SELECT a.detail_segmen, a.id_paket, b.keterangan FROM antrian a, segmen b WHERE a.id_segmen=b.id AND a.id_kunjungan='$d[id_kunjungan]' AND a.status_aktif='Y'"));
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
			<strong>View Pemeriksaan Extremitas</strong>
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
								<td>Keterangan</td>
								<td>:</td>
								<td><?php echo $d['keterangan'];?></td>
							</tr>
						</table>
					</div>
					
					<p class="title-dark">Pemeriksaan Extremitas</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-2 form-control-label">1. Tulang/Sendi</label>
							<div class="col-md-10">
								: 
								<?php
								if($d['extremitas1_hasil']==1){
									echo "Normal";
								}
								else{
									echo "Tidak Normal";
								}
								echo " ($d[extremitas1_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">2. Otot-otot/Tonus</label>
							<div class="col-md-10">
								: 
								<?php
								if($d['extremitas2_hasil']==1){
									echo "Normal";
								}
								else{
									echo "Tidak Normal";
								}
								echo " ($d[extremitas2_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">3. Jari-jari/Kuku</label>
							<div class="col-md-10">
								: 
								<?php
								if($d['extremitas3_hasil']==1){
									echo "Normal";
								}
								else{
									echo "Tidak Normal";
								}
								echo " ($d[extremitas3_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">4. Tangan</label>
							<div class="col-md-10">
								: 
								<?php
								if($d['extremitas4_hasil']==1){
									echo "Normal";
								}
								else{
									echo "Tidak Normal";
								}
								echo " ($d[extremitas4_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">5. Kaki</label>
							<div class="col-md-10">
								: 
								<?php
								if($d['extremitas5_hasil']==1){
									echo "Normal";
								}
								else{
									echo "Tidak Normal";
								}
								echo " ($d[extremitas5_keterangan])";
								?>
							</div>
						</div>
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
						url: 'data-pasien-extremitas',
						data: dataString2,
						success: function(msg){
							$("#data_extremitas").html(msg);
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