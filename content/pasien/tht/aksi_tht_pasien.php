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
	if ($module=='tht' AND $act=='data_tht'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Pemeriksaan THT</strong>
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
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_tht WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
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
						url: 'form-tambah-pasien-tht',
						data: dataString2,
						success: function(msg){
							$("#data_tht").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-tht',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_tht").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus tht ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-tht',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_tht").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-tht',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_tht").html(msg);
								alert("tht berhasil dihapus");
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
						url: 'view-pasien-tht',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_tht").html(msg);
						}
					});
				});
			});
			</script>
		<?php
	}
	
	elseif ($module=='tht' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_tht" class="form-horizontal" action="aksi-tambah-pasien-tht" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Pemeriksaan THT</strong>
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
					<p class="title-dark">Pemeriksaan THT</p>
					<div class="padding-20">
						<p class="title-dark">Telinga</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-2 form-control-label">1. Bentuk</label>
								<div class="col-md-2">
									<select name="telinga1_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="telinga1_keterangan" placeholder="Keterangan">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">2. Lubang Telinga</label>
								<div class="col-md-2">
									<select name="telinga2_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="telinga2_keterangan" placeholder="Keterangan">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">3. Memberan Tympani</label>
								<div class="col-md-2">
									<select name="telinga3_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="telinga3_keterangan" placeholder="Keterangan">
								</div>
							</div>
						</div>
						
						<p class="title-dark">Hidung</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-2 form-control-label">1. Bentuk</label>
								<div class="col-md-2">
									<select name="hidung1_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="hidung1_keterangan" placeholder="Keterangan">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">2. Septum</label>
								<div class="col-md-2">
									<select name="hidung2_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="hidung2_keterangan" placeholder="Keterangan">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">3. Concha</label>
								<div class="col-md-2">
									<select name="hidung3_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="hidung3_keterangan" placeholder="Keterangan">
								</div>
							</div>
						</div>
						
						<p class="title-dark">Tenggorokan</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-2 form-control-label">1. Faring</label>
								<div class="col-md-2">
									<select name="tenggorokan1_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="tenggorokan1_keterangan" placeholder="Keterangan">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">2. Tonsil</label>
								<div class="col-md-2">
									<select name="tenggorokan2_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="tenggorokan2_keterangan" placeholder="Keterangan">
								</div>
							</div>
							
						</div>
						
						<p class="title-dark">Lain-lain</p>
						<div class="padding-20">
							<div class="form-group row">
								<div class="col-md-12">
									<textarea name="lainlain" class="form-control"></textarea>
								</div>
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
			$('#tambah_pasien_tht').on('submit',(function(e) {
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
					url: 'data-pasien-tht',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_tht").html(msg);
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
					url: 'data-pasien-tht',
					data: dataString2,
					success: function(msg){
						$("#data_tht").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='tht' AND $act=='input'){
		/*tht*/
		pg_query($dbconn,"INSERT INTO pasien_tht (id_pasien, id_kunjungan, id_unit, waktu_input, status_hapus, telinga1_hasil, telinga1_keterangan, telinga2_hasil, telinga2_keterangan, telinga3_hasil, telinga3_keterangan, hidung1_hasil, hidung1_keterangan, hidung2_hasil, hidung2_keterangan, hidung3_hasil, hidung3_keterangan, tenggorokan1_hasil, tenggorokan1_keterangan, tenggorokan2_hasil, tenggorokan2_keterangan, keterangan, lainlain, id_user) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', '$_SESSION[id_units]', '$tgl_sekarang $jam_sekarang', 'N', '$_POST[telinga1_hasil]', '$_POST[telinga1_keterangan]', '$_POST[telinga2_hasil]', '$_POST[telinga2_keterangan]', '$_POST[telinga3_hasil]', '$_POST[telinga3_keterangan]', '$_POST[hidung1_hasil]', '$_POST[hidung1_keterangan]', '$_POST[hidung2_hasil]', '$_POST[hidung2_keterangan]','$_POST[hidung3_hasil]', '$_POST[hidung3_keterangan]', '$_POT[tenggorokan1_hasil]', '$_POST[tenggorokan1_keterangan]', '$_POST[tenggorokan2_hasil]', '$_POST[tenggorokan2_keterangan]', '$_POST[keterangan]', '$_POST[lainlain]', '$_SESSION[login_user]')");
		
	}
	
	elseif ($module=='tht' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_tht WHERE id='$_POST[id]'"));
		$id_tht=$d['id'];
		?>
		<form id="edit_pasien_tht" class="form-horizontal" action="aksi-edit-pasien-tht" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_tht">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Pemeriksaan THT</strong>
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
						<p class="title-dark">Pemeriksaan THT</p>
						<div class="padding-20">
							<p class="title-dark">Telinga</p>
							<div class="padding-20">
								<div class="form-group row">
									<label class="col-md-2 form-control-label">1. Bentuk</label>
									<div class="col-md-2">
										<select name="telinga1_hasil" class="form-control">
											<option value="1" <?php if($d['telinga1_hasil']==1){echo "selected";}?>>Normal</option>
											<option value="2" <?php if($d['telinga1_hasil']==2){echo "selected";}?>>Tidak Normal</option>
										</select>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="telinga1_keterangan" placeholder="Keterangan" value="<?php echo $d['telinga1_keterangan'];?>">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-md-2 form-control-label">2. Lubang Telinga</label>
									<div class="col-md-2">
										<select name="telinga2_hasil" class="form-control">
											<option value="1" <?php if($d['telinga2_hasil']==1){echo "selected";}?>>Normal</option>
											<option value="2" <?php if($d['telinga2_hasil']==2){echo "selected";}?>>Tidak Normal</option>
										</select>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="telinga2_keterangan" placeholder="Keterangan" value="<?php echo $d['telinga2_keterangan'];?>">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-md-2 form-control-label">3. Memberan Tympani</label>
									<div class="col-md-2">
										<select name="telinga3_hasil" class="form-control">
											<option value="1" <?php if($d['telinga3_hasil']==1){echo "selected";}?>>Normal</option>
											<option value="2" <?php if($d['telinga3_hasil']==2){echo "selected";}?>>Tidak Normal</option>
										</select>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="telinga3_keterangan" placeholder="Keterangan" value="<?php echo $d['telinga3_keterangan'];?>">
									</div>
								</div>
							</div>
							
							<p class="title-dark">Hidung</p>
							<div class="padding-20">
								<div class="form-group row">
									<label class="col-md-2 form-control-label">1. Bentuk</label>
									<div class="col-md-2">
										<select name="hidung1_hasil" class="form-control">
											<option value="1" <?php if($d['hidung1_hasil']==1){echo "selected";}?>>Normal</option>
											<option value="2" <?php if($d['hidung1_hasil']==2){echo "selected";}?>>Tidak Normal</option>
										</select>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="hidung1_keterangan" placeholder="Keterangan" value="<?php echo $d['hidung1_keterangan'];?>">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-md-2 form-control-label">2. Septum</label>
									<div class="col-md-2">
										<select name="hidung2_hasil" class="form-control">
											<option value="1" <?php if($d['hidung2_hasil']==1){echo "selected";}?>>Normal</option>
											<option value="2" <?php if($d['hidung2_hasil']==2){echo "selected";}?>>Tidak Normal</option>
										</select>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="hidung2_keterangan" placeholder="Keterangan" value="<?php echo $d['hidung2_keterangan'];?>">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-md-2 form-control-label">3. Concha</label>
									<div class="col-md-2">
										<select name="hidung3_hasil" class="form-control">
											<option value="1" <?php if($d['hidung3_hasil']==1){echo "selected";}?>>Normal</option>
											<option value="2" <?php if($d['hidung3_hasil']==2){echo "selected";}?>>Tidak Normal</option>
										</select>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="hidung3_keterangan" placeholder="Keterangan" value="<?php echo $d['hidung3_keterangan'];?>">
									</div>
								</div>
							</div>
							
							<p class="title-dark">Tenggorokan</p>
							<div class="padding-20">
								<div class="form-group row">
									<label class="col-md-2 form-control-label">1. Faring</label>
									<div class="col-md-2">
										<select name="tenggorokan1_hasil" class="form-control">
											<option value="1" <?php if($d['tenggorokan1_hasil']==1){echo "selected";}?>>Normal</option>
											<option value="2" <?php if($d['tenggorokan1_hasil']==2){echo "selected";}?>>Tidak Normal</option>
										</select>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="tenggorokan1_keterangan" placeholder="Keterangan" value="<?php echo $d['tenggorokan1_keterangan'];?>">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-md-2 form-control-label">2. Tonsil</label>
									<div class="col-md-2">
										<select name="tenggorokan2_hasil" class="form-control">
											<option value="1" <?php if($d['tenggorokan2_hasil']==1){echo "selected";}?>>Normal</option>
											<option value="2" <?php if($d['tenggorokan2_hasil']==2){echo "selected";}?>>Tidak Normal</option>
										</select>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="tenggorokan2_keterangan" placeholder="Keterangan" value="<?php echo $d['tenggorokan2_keterangan'];?>">
									</div>
								</div>
								
							</div>
							
							<p class="title-dark">Lain-lain</p>
							<div class="padding-20">
								<div class="form-group row">
									<div class="col-md-12">
										<textarea name="lainlain" class="form-control"><?php echo $d['lainlain'];?></textarea>
									</div>
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
				$('#edit_pasien_tht').on('submit',(function(e) {
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
						url: 'data-pasien-tht',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_tht").html(msg);
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
						url: 'data-pasien-tht',
						data: dataString2,
						success: function(msg){
							$("#data_tht").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='tht' AND $act=='update'){
		$id_tht=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_tht SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', telinga1_hasil='$_POST[telinga1_hasil]', telinga1_keterangan='$_POST[telinga1_keterangan]', telinga2_hasil='$_POST[telinga2_hasil]', telinga2_keterangan='$_POST[telinga2_keterangan]', telinga3_hasil='$_POST[telinga3_hasil]', telinga3_keterangan='$_POST[telinga3_keterangan]', hidung1_hasil='$_POST[hidung1_hasil]', hidung1_keterangan='$_POST[hidung1_keterangan]', hidung2_hasil='$_POST[hidung2_hasil]', hidung2_keterangan='$_POST[hidung2_keterangan]', hidung3_hasil='$_POST[hidung3_hasil]', hidung3_keterangan='$_POST[hidung3_keterangan]', tenggorokan1_hasil='$_POST[tenggorokan1_hasil]', tenggorokan1_keterangan='$_POST[tenggorokan1_keterangan]', tenggorokan2_hasil='$_POST[tenggorokan2_hasil]', tenggorokan2_keterangan='$_POST[tenggorokan2_keterangan]', lainlain='$_POST[lainlain]', keterangan='$_POST[keterangan]' WHERE id='$id_tht'");
		
	}
	
	elseif ($module=='tht' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_tht SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	elseif ($module=='tht' AND $act=='view'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_tht WHERE id='$_POST[id]'"));
		$id_tht=$d['id'];
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
			<strong>View Pemeriksaan THT</strong>
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
					
					<p class="title-dark">Pemeriksaan THT</p>
					<div class="padding-20">
						<p class="title-dark">Telinga</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-2 form-control-label">1. Bentuk</label>
								<div class="col-md-10">
									: 
									<?php
									if($d['telinga1_hasil']==1){
										echo "Normal";
									}
									else{
										echo "Tidak Normal";
									}
									echo " ($d[telinga1_keterangan])";
									?>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">2. Lubang Telinga</label>
								<div class="col-md-10">
									: 
									<?php
									if($d['telinga2_hasil']==1){
										echo "Normal";
									}
									else{
										echo "Tidak Normal";
									}
									echo " ($d[telinga2_keterangan])";
									?>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">3. Memberan Tympani</label>
								<div class="col-md-10">
									: 
									<?php
									if($d['telinga3_hasil']==1){
										echo "Normal";
									}
									else{
										echo "Tidak Normal";
									}
									echo " ($d[telinga3_keterangan])";
									?>
								</div>
							</div>
						</div>
						
						<p class="title-dark">Hidung</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-2 form-control-label">1. Bentuk</label>
								<div class="col-md-10">
									: 
									<?php
									if($d['hidung1_hasil']==1){
										echo "Normal";
									}
									else{
										echo "Tidak Normal";
									}
									echo " ($d[hidung1_keterangan])";
									?>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">2. Septum</label>
								<div class="col-md-10">
									: 
									<?php
									if($d['hidung2_hasil']==1){
										echo "Normal";
									}
									else{
										echo "Tidak Normal";
									}
									echo " ($d[hidung2_keterangan])";
									?>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">3. Concha</label>
								<div class="col-md-10">
									: 
									<?php
									if($d['hidung3_hasil']==1){
										echo "Normal";
									}
									else{
										echo "Tidak Normal";
									}
									echo " ($d[hidung3_keterangan])";
									?>
								</div>
							</div>
						</div>
						
						<p class="title-dark">Tenggorokan</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-2 form-control-label">1. Faring</label>
								<div class="col-md-10">
									: 
									<?php
									if($d['tenggorokan1_hasil']==1){
										echo "Normal";
									}
									else{
										echo "Tidak Normal";
									}
									echo " ($d[tenggorokan1_keterangan])";
									?>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">2. Tonsil</label>
								<div class="col-md-10">
									: 
									<?php
									if($d['tenggorokan2_hasil']==1){
										echo "Normal";
									}
									else{
										echo "Tidak Normal";
									}
									echo " ($d[tenggorokan2_keterangan])";
									?>
								</div>
							</div>
							
						</div>
						
						<p class="title-dark">Lain-lain</p>
						<div class="padding-20">
							<div class="form-group row">
								<div class="col-md-12">
									<?php echo $d['lainlain'];?>
								</div>
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
						url: 'data-pasien-tht',
						data: dataString2,
						success: function(msg){
							$("#data_tht").html(msg);
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