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
	if ($module=='leher' AND $act=='data_leher'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Pemeriksaan Leher</strong>
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
								<th colspan="2">Bentuk</th>
								<th colspan="2">Thyroid</th>
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
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_leher WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
								
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
									
									if($r['leher1_hasil']==1){
										$leher1_hasil="Normal";
									}
									else{
										$leher1_hasil="Tidak Normal";
									}
									
									if($r['leher1_hasil']==1){
										$leher2_hasil="Normal";
									}
									else{
										$leher2_hasil="Tidak Normal";
									}
									
									
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo "$tanggal/$jam";?></td>
										<td><?php echo $kunjungan;?></td>
										<td><?php echo $leher1_hasil;?></td>
										<td><?php echo $r['leher1_keterangan'];?></td>
										<td><?php echo $leher2_hasil;?></td>
										<td><?php echo $r['leher2_keterangan'];?></td>
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
						url: 'form-tambah-pasien-leher',
						data: dataString2,
						success: function(msg){
							$("#data_leher").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-leher',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_leher").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus leher ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-leher',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_leher").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-leher',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_leher").html(msg);
								alert("leher berhasil dihapus");
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
	
	elseif ($module=='leher' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_leher" class="form-horizontal" action="aksi-tambah-pasien-leher" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Pemeriksaan Leher</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<p class="title-dark">Pemeriksaan Leher</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								1. Bentuk
							</label>
							<div class="col-md-2">
								<select name="leher1_hasil" class="form-control">
									<option value="1">Normal</option>
									<option value="2">Tidak Normal</option>
								</select>
							</div>
							<div class="col-md-7">
								<input type="text" class="form-control" name="leher1_keterangan" placeholder="Keterangan">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								2. Thyroid
							</label>
							<div class="col-md-2">
								<select name="leher2_hasil" class="form-control">
									<option value="1">Normal</option>
									<option value="2">Tidak Normal</option>
								</select>
							</div>
							<div class="col-md-7">
								<input type="text" class="form-control" name="leher2_keterangan" placeholder="Keterangan">
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
			$('#tambah_pasien_leher').on('submit',(function(e) {
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
					url: 'data-pasien-leher',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_leher").html(msg);
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
					url: 'data-pasien-leher',
					data: dataString2,
					success: function(msg){
						$("#data_leher").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='leher' AND $act=='input'){
		/*leher*/
		pg_query($dbconn,"INSERT INTO pasien_leher (id_kunjungan, id_pasien, id_unit, id_user, status_hapus, waktu_input, leher1_hasil, leher1_keterangan, leher2_hasil, leher2_keterangan, keterangan) VALUES ('$_POST[id_kunjungan]', '$_POST[id_pasien]', '$_SESSION[id_units]', '$_SESSION[login_user]', 'N', '$tgl_sekarang $jam_sekarang', '$_POST[leher1_hasil]', '$_POST[leher1_keterangan]', '$_POST[leher2_hasil]', '$_POST[leher2_keterangan]', '$_POST[keterangan]')");
		
	}
	
	elseif ($module=='leher' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_leher WHERE id='$_POST[id]'"));
		$id_leher=$d['id'];
		?>
		<form id="edit_pasien_leher" class="form-horizontal" action="aksi-edit-pasien-leher" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_leher">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Pemerikssaan Leher</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<p class="title-dark">Pemeriksaan Leher</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									1. Bentuk
								</label>
								<div class="col-md-2">
									<select name="leher1_hasil" class="form-control">
										<option value="1" <?php if($d['leher1_hasil']==1){echo "selected";}?>>Normal</option>
										<option value="2" <?php if($d['leher1_hasil']==2){echo "selected";}?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-7">
									<input type="text" class="form-control" name="leher1_keterangan" placeholder="Keterangan" value="<?php echo $d['leher1_keterangan'];?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									2. Thyroid
								</label>
								<div class="col-md-2">
									<select name="leher2_hasil" class="form-control">
										<option value="1" <?php if($d['leher2_hasil']==1){echo "selected";}?>>Normal</option>
										<option value="2" <?php if($d['leher2_hasil']==2){echo "selected";}?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-7">
									<input type="text" class="form-control" name="leher2_keterangan" placeholder="Keterangan" value="<?php echo $d['leher2_keterangan'];?>">
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
				$('#edit_pasien_leher').on('submit',(function(e) {
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
						url: 'data-pasien-leher',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_leher").html(msg);
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
						url: 'data-pasien-leher',
						data: dataString2,
						success: function(msg){
							$("#data_leher").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='leher' AND $act=='update'){
		$id_leher=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_leher SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', leher1_hasil='$_POST[leher1_hasil]', leher1_keterangan='$_POST[leher1_keterangan]', leher2_hasil='$_POST[leher2_hasil]', leher2_keterangan='$_POST[leher2_keterangan]', keterangan='$_POST[keterangan]'  WHERE id='$id_leher'");
	}
	
	elseif ($module=='leher' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_leher SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	pg_close($dbconn);
}
?>