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
	if ($module=='rektal' AND $act=='data_rektal'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Pemeriksaan Rektal</strong>
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
								<th rowspan="2" width="30px">No.</th>
								<th rowspan="2" width="140px">Tanggal/Jam</th>
								<th rowspan="2" >Kunjungan</th>
								<th colspan="2">Haemorrhoid</th>
								<th colspan="2">Anus/Rectum/Parianal</th>
								<th rowspan="2">Keterangan</th>
								<th rowspan="3" width="80px">#</th>
							</tr>
							<tr>
								<th>Hasil</th>
								<th>Keterangan</th>
								<th>Hasil</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_rektal WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
								
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
									
									if($r['rektal1_hasil']==1){
										$rektal1_hasil="Normal";
									}
									else{
										$rektal1_hasil="Tidak Normal";
									}
									
									if($r['rektal1_hasil']==1){
										$rektal2_hasil="Normal";
									}
									else{
										$rektal2_hasil="Tidak Normal";
									}
									
									
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo "$tanggal/$jam";?></td>
										<td><?php echo $kunjungan;?></td>
										<td><?php echo $rektal1_hasil;?></td>
										<td><?php echo $r['rektal1_keterangan'];?></td>
										<td><?php echo $rektal2_hasil;?></td>
										<td><?php echo $r['rektal2_keterangan'];?></td>
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
						url: 'form-tambah-pasien-rektal',
						data: dataString2,
						success: function(msg){
							$("#data_rektal").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-rektal',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_rektal").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus rektal ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-rektal',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_rektal").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-rektal',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_rektal").html(msg);
								alert("rektal berhasil dihapus");
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
	
	elseif ($module=='rektal' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_rektal" class="form-horizontal" action="aksi-tambah-pasien-rektal" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Pemeriksaan Rektal</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<p class="title-dark">Pemeriksaan Rektal</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								1. Haemorrhoid
							</label>
							<div class="col-md-2">
								<select name="rektal1_hasil" class="form-control">
									<option value="1">Normal</option>
									<option value="2">Tidak Normal</option>
								</select>
							</div>
							<div class="col-md-7">
								<input type="text" class="form-control" name="rektal1_keterangan" placeholder="Keterangan">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								2. Anus/Rectum/Parianal
							</label>
							<div class="col-md-2">
								<select name="rektal2_hasil" class="form-control">
									<option value="1">Normal</option>
									<option value="2">Tidak Normal</option>
								</select>
							</div>
							<div class="col-md-7">
								<input type="text" class="form-control" name="rektal2_keterangan" placeholder="Keterangan">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								3. Keterangan/Catatan
							</label>
							<div class="col-md-9">
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
			$('#tambah_pasien_rektal').on('submit',(function(e) {
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
					url: 'data-pasien-rektal',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_rektal").html(msg);
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
					url: 'data-pasien-rektal',
					data: dataString2,
					success: function(msg){
						$("#data_rektal").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='rektal' AND $act=='input'){
		/*rektal*/
		pg_query($dbconn,"INSERT INTO pasien_rektal (id_kunjungan, id_pasien, id_unit, id_user, status_hapus, waktu_input, rektal1_hasil, rektal1_keterangan, rektal2_hasil, rektal2_keterangan, keterangan) VALUES ('$_POST[id_kunjungan]', '$_POST[id_pasien]', '$_SESSION[id_units]', '$_SESSION[login_user]', 'N', '$tgl_sekarang $jam_sekarang', '$_POST[rektal1_hasil]', '$_POST[rektal1_keterangan]', '$_POST[rektal2_hasil]', '$_POST[rektal2_keterangan]', '$_POST[keterangan]')");
		
	}
	
	elseif ($module=='rektal' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_rektal WHERE id='$_POST[id]'"));
		$id_rektal=$d['id'];
		?>
		<form id="edit_pasien_rektal" class="form-horizontal" action="aksi-edit-pasien-rektal" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_rektal">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Pemerikssaan Rektal</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<p class="title-dark">Pemeriksaan Rektal</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									1. Haemorrhoid
								</label>
								<div class="col-md-2">
									<select name="rektal1_hasil" class="form-control">
										<option value="1" <?php if($d['rektal1_hasil']==1){echo "selected";}?>>Normal</option>
										<option value="2" <?php if($d['rektal1_hasil']==2){echo "selected";}?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-7">
									<input type="text" class="form-control" name="rektal1_keterangan" placeholder="Keterangan" value="<?php echo $d['rektal1_keterangan'];?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									2. Anus/Rectum/Parianal
								</label>
								<div class="col-md-2">
									<select name="rektal2_hasil" class="form-control">
										<option value="1" <?php if($d['rektal2_hasil']==1){echo "selected";}?>>Normal</option>
										<option value="2" <?php if($d['rektal2_hasil']==2){echo "selected";}?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-7">
									<input type="text" class="form-control" name="rektal2_keterangan" placeholder="Keterangan" value="<?php echo $d['rektal2_keterangan'];?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									3. Keterangan/Catatan
								</label>
								<div class="col-md-9">
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
				$('#edit_pasien_rektal').on('submit',(function(e) {
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
						url: 'data-pasien-rektal',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_rektal").html(msg);
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
						url: 'data-pasien-rektal',
						data: dataString2,
						success: function(msg){
							$("#data_rektal").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='rektal' AND $act=='update'){
		$id_rektal=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_rektal SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', rektal1_hasil='$_POST[rektal1_hasil]', rektal1_keterangan='$_POST[rektal1_keterangan]', rektal2_hasil='$_POST[rektal2_hasil]', rektal2_keterangan='$_POST[rektal2_keterangan]', keterangan='$_POST[keterangan]'  WHERE id='$id_rektal'");
	}
	
	elseif ($module=='rektal' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_rektal SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	pg_close($dbconn);
}
?>