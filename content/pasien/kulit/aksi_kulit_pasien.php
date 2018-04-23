<?php
session_start();
//error_reporting(0);
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
	if ($module=='kulit' AND $act=='data_kulit'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Pemeriksaan Kulit</strong>
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
								<th width="30px">No.</th>
								<th width="140px">Tanggal/Jam</th>
								<th>Kunjungan</th>
								<th>Warna Kulit</th>
								<th>Kelainana Kulit</th>
								<th>Keterangan</th>
								<th width="80px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_kulit WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
								
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
										<td><?php echo "$tanggal/$jam";?></td>
										<td><?php echo $kunjungan;?></td>
										<td><?php echo $r['warna'];?></td>
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
						url: 'form-tambah-pasien-kulit',
						data: dataString2,
						success: function(msg){
							$("#data_kulit").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-kulit',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_kulit").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus kulit ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-kulit',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_kulit").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-kulit',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_kulit").html(msg);
								alert("kulit berhasil dihapus");
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
	
	elseif ($module=='kulit' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_kulit" class="form-horizontal" action="aksi-tambah-pasien-kulit" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Pemeriksaan Kulit</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<p class="title-dark">Pemeriksaan Kulit</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								1. Warna Kulit
							</label>
							<div class="col-md-9">
								<input type="text" name="warna" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								2. Kelainan Kulit
							</label>
							<div class="col-md-9">
								<input type="text" name="kelainan" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">
								3. Keterangan
							</label>
							<div class="col-md-9">
								<input type="text" name="keterangan" class="form-control">
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
			$('#tambah_pasien_kulit').on('submit',(function(e) {
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
					url: 'data-pasien-kulit',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_kulit").html(msg);
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
					url: 'data-pasien-kulit',
					data: dataString2,
					success: function(msg){
						$("#data_kulit").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='kulit' AND $act=='input'){
		/*kulit*/
		pg_query($dbconn,"INSERT INTO pasien_kulit (id_kunjungan, id_pasien, id_unit, id_user, status_hapus, waktu_input, keterangan, warna, kelainan) VALUES ('$_POST[id_kunjungan]', '$_POST[id_pasien]', '$_SESSION[id_units]', '$_SESSION[login_user]', 'N', '$tgl_sekarang $jam_sekarang', '$_POST[keterangan]', '$_POST[warna]', '$_POST[kelainan]')");
		
	}
	
	elseif ($module=='kulit' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_kulit WHERE id='$_POST[id]'"));
		$id_kulit=$d['id'];
		?>
		<form id="edit_pasien_kulit" class="form-horizontal" action="aksi-edit-pasien-kulit" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_kulit">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Pemerikssaan Kulit</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<p class="title-dark">Pemeriksaan Kulit</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									1. Warna Kulit
								</label>
								<div class="col-md-9">
									<input type="text" name="warna" class="form-control" value="<?php echo $d['warna'];?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									2. Kelainan Kulit
								</label>
								<div class="col-md-9">
									<input type="text" name="kelainan" class="form-control" value="<?php echo $d['kelainan'];?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									3. Keterangan
								</label>
								<div class="col-md-9">
									<input type="text" name="keterangan" class="form-control" value="<?php echo $d['keterangan'];?>">
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
				$('#edit_pasien_kulit').on('submit',(function(e) {
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
						url: 'data-pasien-kulit',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_kulit").html(msg);
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
						url: 'data-pasien-kulit',
						data: dataString2,
						success: function(msg){
							$("#data_kulit").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='kulit' AND $act=='update'){
		$id_kulit=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_kulit SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', keterangan='$_POST[keterangan]', warna='$_POST[warna]', kelainan='$_POST[kelainan]'  WHERE id='$id_kulit'");
	}
	
	elseif ($module=='kulit' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_kulit SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	pg_close($dbconn);
}
?>