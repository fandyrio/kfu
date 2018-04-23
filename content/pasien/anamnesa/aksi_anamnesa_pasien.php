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
	if ($module=='anamnesa' AND $act=='data_anamnesa'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Anamnesa</strong>
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
								<th>Keterangan</th>
								<th width="80px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_anamnesa WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
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
						url: 'form-tambah-pasien-anamnesa',
						data: dataString2,
						success: function(msg){
							$("#data_anamnesa").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-anamnesa',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_anamnesa").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus anamnesa ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-anamnesa',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_anamnesa").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-anamnesa',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_anamnesa").html(msg);
								alert("Anamnesa berhasil dihapus");
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
						url: 'view-pasien-anamnesa',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_anamnesa").html(msg);
						}
					});
				});
			});
			</script>
		<?php
	}
	
	elseif ($module=='anamnesa' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_anamesa" class="form-horizontal" action="aksi-tambah-pasien-anamnesa" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Anamnesa</strong>
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
					<p class="title-dark">Riwayat Kesehatan</p> <!--Keluhan Saat ini-->
					<div class="padding-20">
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_ksi");
						$no=1;
						while($r=pg_fetch_array($tampil)){
							?>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									<input type="checkbox" name="checked_a[]" value="<?php echo $r['id'];?>" checked> <?php echo "$no. $r[nama]";?>
								</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="hasil_a#<?php echo $r['id'];?>" placeholder="Hasil">
								</div>
								<div class="col-md-5">
									<input type="text" class="form-control" name="keterangan_a#<?php echo $r['id'];?>" placeholder="Keterangan">
								</div>
							</div>
							<?php
							$no++;
						}
						?>
					</div>
					<p class="title-dark">Riwayat Kesehatan Dahulu</p>
					<div class="padding-20">
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_rpd");
						$no=1;
						while($r=pg_fetch_array($tampil)){
							?>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									<input type="checkbox" name="checked_b[]" value="<?php echo $r['id'];?>" checked> <?php echo "$no. $r[nama]";?>
								</label>
								<div class="col-md-2">
									<select name="hasil_b#<?php echo $r['id'];?>" class="form-control">
										<option value="N">Tidak Ada</option>
										<option value="Y">Ada</option>
									</select>
								</div>
								<div class="col-md-5">
								<?php
								if($r['id']<3){
									?>
									<input type="text" class="form-control" name="hasil1_b#<?php echo $r['id'];?>" placeholder="Hasil">
									<?php
								}
								elseif($r['id']==3){
									?>
									<div class="row">
										<div class="col-md-2">
											selama 
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" name="hasil1_b#<?php echo $r['id'];?>" placeholder="Bulan">
										</div>
										
										<div class="col-md-4">
											Bulan, pada tahun
										</div>
										
										<div class="col-md-3">
											<input type="text" class="form-control" name="hasil2_b#<?php echo $r['id'];?>" placeholder="Tahun">
										</div>
									</div>
									
									<?php
								}
								else{
									?>
									<div class="row">
										<div class="col-md-2">
											tulang
										</div>
										<div class="col-md-10">
											<input type="text" class="form-control" name="hasil1_b#<?php echo $r['id'];?>" placeholder="">
										</div>
										
									</div>
									<?php
								}
								?>
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" name="keterangan_b#<?php echo $r['id'];?>" placeholder="Keterangan">
								</div>
							</div>
							<?php
							$no++;
						}
						?>
					</div>
					
					<p class="title-dark">Riwayat Kesehatan Keluarga</p>
					<div class="padding-20">
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_rpk");
						$no=1;
						while($r=pg_fetch_array($tampil)){
							?>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									<input type="checkbox" name="checked_c[]" value="<?php echo $r['id'];?>" checked>
									<?php echo "$no. $r[nama]";?>
								</label>
								<div class="col-md-2">
									<select name="hasil_c#<?php echo $r['id'];?>" class="form-control">
										<option value="N">Tidak Ada</option>
										<option value="Y">Ada</option>
									</select>
								</div>
								<div class="col-md-7">
									<input type="text" class="form-control" name="keterangan_c#<?php echo $r['id'];?>" placeholder="Keterangan">
								</div>
							</div>
							<?php
							$no++;
						}
						?>
					</div>
					
					<p class="title-dark">Riwayat Hazard Lingkungan Kerja</p>
					<div class="padding-20">
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_rhlk");
						$no=1;
						while($r=pg_fetch_array($tampil)){
							?>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									<input type="checkbox" name="checked_d[]" value="<?php echo $r['id'];?>" checked>
									<?php echo "$no. $r[nama]";?>
								</label>
								<div class="col-md-2">
									<select name="hasil_d#<?php echo $r['id'];?>" class="form-control">
										<option value="N">Tidak Ada</option>
										<option value="Y">Ada</option>
									</select>
								</div>
								<div class="col-md-1">
									<input type="text" class="form-control" name="hasil1_d#<?php echo $r['id'];?>" placeholder="">
								</div>
								
								<div class="col-md-2">
									Jam/hari, selama
								</div>
								
								<div class="col-md-1">
									<input type="text" class="form-control" name="hasil2_d#<?php echo $r['id'];?>" placeholder="">
								</div>
								<div class="col-md-1">
									tahun
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" name="keterangan_d#<?php echo $r['id'];?>" placeholder="Keterangan">
								</div>
							</div>
							<?php
							$no++;
						}
						?>
					</div>
					
					<p class="title-dark">Riwayat Kecelakaan Kerja</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-1 form-control-label">1. </label>
							<div class="col-md-11">
								<input type="text" class="form-control" name="riwayat_e#1" placeholder="Riwayat">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-1 form-control-label">2. </label>
							<div class="col-md-11">
								<input type="text" class="form-control" name="riwayat_e#2" placeholder="Riwayat">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-1 form-control-label">3. </label>
							<div class="col-md-11">
								<input type="text" class="form-control" name="riwayat_e#3" placeholder="Riwayat">
							</div>
						</div>
					</div>
					
					<p class="title-dark">Kebiasaan</p>
					<div class="padding-20">
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_kebiasaan");
						$no=1;
						while($r=pg_fetch_array($tampil)){
							?>
							<div class="form-group row">
								<label class="col-md-3 form-control-label">
									<input type="checkbox" name="checked_f[]" value="<?php echo $r['id'];?>" checked>
									<?php echo "$no. $r[nama]";?>
								</label>
								<div class="col-md-2">
									<select name="hasil_f#<?php echo $r['id'];?>" class="form-control">
										<option value="N">Tidak Ada</option>
										<option value="Y">Ada</option>
									</select>
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" name="hasil2_f#<?php echo $r['id'];?>" placeholder="">
								</div>
								
								<div class="col-md-2">
									<?php echo $r['satuan'];?>
								</div>
								<div class="col-md-3">
									<input type="text" class="form-control" name="keterangan_f#<?php echo $r['id'];?>" placeholder="Keterangan">
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
			$('#tambah_pasien_anamesa').on('submit',(function(e) {
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
					url: 'data-pasien-anamnesa',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_anamnesa").html(msg);
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
					url: 'data-pasien-anamnesa',
					data: dataString2,
					success: function(msg){
						$("#data_anamnesa").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='anamnesa' AND $act=='input'){
		/*anamnesa*/
		$result=pg_query($dbconn,"INSERT INTO pasien_anamnesa (id_kunjungan, id_pasien, id_unit, waktu_input, id_user, keterangan, status_hapus) VALUES ('$_POST[id_kunjungan]', '$_POST[id_pasien]', '$_SESSION[id_units]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[keterangan]', 'N') RETURNING id");
		
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		
		/*keluhan saat ini*/
		foreach($_POST['checked_a'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_a#'.$value];
			$keterangan=$_POST['keterangan_a#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_ksi (id_anamnesa, id_anamnesa_ksi, hasil, keterangan) VALUES ('$insert_id', '$id', '$hasil', '$keterangan')");
		}
		
		/*riwayat penyakit dahulu*/
		foreach($_POST['checked_b'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_b#'.$value];
			$hasil1=$_POST['hasil1_b#'.$value];
			$hasil2=$_POST['hasil2_b#'.$value];
			$keterangan=$_POST['keterangan_b#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_rpd (id_anamnesa, id_anamnesa_rpd, hasil, hasil1, hasil2, keterangan) VALUES ('$insert_id', '$id', '$hasil', '$hasil1', '$hasil2', '$keterangan')");
		}
		
		/*riwayat penyakit keluarga*/
		foreach($_POST['checked_c'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_c#'.$value];
			$keterangan=$_POST['keterangan_c#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_rpk (id_anamnesa, id_anamnesa_rpk, hasil, keterangan) VALUES ('$insert_id', '$id', '$hasil', '$keterangan')");
		}
		
		/*riwayat hazard lingkungan kerja*/
		foreach($_POST['checked_d'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_d#'.$value];
			$hasil1=$_POST['hasil1_d#'.$value];
			$hasil2=$_POST['hasil2_d#'.$value];
			$keterangan=$_POST['keterangan_d#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_rhlk (id_anamnesa, id_anamnesa_rhlk, hasil, hasil1, hasil2, keterangan) VALUES ('$insert_id', '$id', '$hasil', '$hasil1', '$hasil2', '$keterangan')");
		}
		
		/*riwayat lingkungan kerja*/
		$riwayat1=$_POST["riwayat_e#1"];
		$riwayat2=$_POST["riwayat_e#2"];
		$riwayat3=$_POST["riwayat_e#3"];
		pg_query($dbconn,"INSERT INTO pasien_anamnesa_kk (id_anamnesa, riwayat1, riwayat2, riwayat3) VALUES ('$insert_id', '$riwayat1', '$riwayat2', '$riwayat3')");
		
		/*kebiasaan*/
		foreach($_POST['checked_f'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_f#'.$value];
			$hasil2=$_POST['hasil2_f#'.$value];
			$keterangan=$_POST['keterangan_f#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_kebiasaan (id_anamnesa, id_anamnesa_kebiasaan, hasil, hasil2, keterangan) VALUES ('$insert_id', '$id', '$hasil', '$hasil2', '$keterangan')");
		}
	}
	
	elseif ($module=='anamnesa' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa WHERE id='$_POST[id]'"));
		$id_anamnesa=$d['id'];
		?>
		<form id="edit_pasien_anamesa" class="form-horizontal" action="aksi-edit-pasien-anamnesa" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_anamnesa">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Anamnesa</strong>
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
						<p class="title-dark">Riwayat Kesehatan</p>
						<div class="padding-20">
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_ksi");
							$no=1;
							while($r=pg_fetch_array($tampil)){
								$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_ksi WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_ksi='$r[id]'"));
								?>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">
										<input type="checkbox" name="checked_a[]" value="<?php echo $r['id'];?>" <?php if($p['id']!=''){echo "checked";}?>><?php echo "$no. $r[nama]";?>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="hasil_a#<?php echo $r['id'];?>" placeholder="Hasil" value="<?php echo $p['hasil'];?>">
									</div>
									<div class="col-md-5">
										<input type="text" class="form-control" name="keterangan_a#<?php echo $r['id'];?>" placeholder="Keterangan" value="<?php echo $p['keterangan'];?>">
									</div>
								</div>
								<?php
								$no++;
							}
							?>
						</div>
						<p class="title-dark">Riwayat Kesehatan Dahulu</p>
						<div class="padding-20">
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_rpd");
							$no=1;
							while($r=pg_fetch_array($tampil)){
								$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_rpd WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_rpd='$r[id]'"));
								?>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">
										<input type="checkbox" name="checked_b[]" value="<?php echo $r['id'];?>" checked> <?php echo "$no. $r[nama]";?>
									</label>
									<div class="col-md-2">
										<select name="hasil_b#<?php echo $r['id'];?>" class="form-control">
											<?php
											if($p['hasil']=='Y'){
												?>
												<option value="Y" selected>Ada</option>
												<option value="N">Tidak Ada</option>
												<?php
											}
											else{
												?>
												<option value="Y">Ada</option>
												<option value="N" selected>Tidak Ada</option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-5">
									<?php
									if($r['id']<3){
										?>
										<input type="text" class="form-control" name="hasil1_b#<?php echo $r['id'];?>" placeholder="Hasil" value="<?php echo $p['hasil1'];?>">
										<?php
									}
									elseif($r['id']==3){
										?>
										<div class="row">
											<div class="col-md-2">
												selama 
											</div>
											<div class="col-md-3">
												<input type="text" class="form-control" name="hasil1_b#<?php echo $r['id'];?>" placeholder="Bulan" value="<?php echo $p['hasil1'];?>">
											</div>
											
											<div class="col-md-4">
												Bulan, pada tahun
											</div>
											
											<div class="col-md-3">
												<input type="text" class="form-control" name="hasil2_b#<?php echo $r['id'];?>" placeholder="Tahun" value="<?php echo $p['hasil2'];?>">
											</div>
										</div>
										<?php
									}
									else{
										?>
										
										<div class="row">
											<div class="col-md-2">
												tulang
											</div>
											<div class="col-md-10">
												<input type="text" class="form-control" name="hasil1_b#<?php echo $r['id'];?>" placeholder="" value="<?php echo $p['hasil1'];?>">
											</div>
											
										</div>
										<?php
									}
									?>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="keterangan_b#<?php echo $r['id'];?>" placeholder="Keterangan" value="<?php echo $p['keterangan'];?>">
									</div>
								</div>
								<?php
								$no++;
							}
							?>
						</div>
						
						<p class="title-dark">Riwayat Kesehatan Keluarga</p>
						<div class="padding-20">
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_rpk");
							$no=1;
							while($r=pg_fetch_array($tampil)){
								$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_rpk WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_rpk='$r[id]'"));
								?>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">
										<input type="checkbox" name="checked_c[]" value="<?php echo $r['id'];?>" checked>
										<?php echo "$no. $r[nama]";?>
									</label>
									<div class="col-md-2">
										<select name="hasil_c#<?php echo $r['id'];?>" class="form-control">
											<?php
											if($p['hasil']=='Y'){
												?>
												<option value="Y" selected>Ada</option>
												<option value="N">Tidak Ada</option>
												<?php
											}
											else{
												?>
												<option value="Y">Ada</option>
												<option value="N" selected>Tidak Ada</option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-7">
										<input type="text" class="form-control" name="keterangan_c#<?php echo $r['id'];?>" placeholder="Keterangan" value="<?php echo $p['keterangan'];?>">
									</div>
								</div>
								<?php
								$no++;
							}
							?>
						</div>
						
						<p class="title-dark">Riwayat Hazard Lingkungan Kerja</p>
						<div class="padding-20">
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_rhlk");
							$no=1;
							while($r=pg_fetch_array($tampil)){
								$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_rhlk WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_rhlk='$r[id]'"));
								?>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">
										<input type="checkbox" name="checked_d[]" value="<?php echo $r['id'];?>" checked>
										<?php echo "$no. $r[nama]";?>
									</label>
									<div class="col-md-2">
										<select name="hasil_d#<?php echo $r['id'];?>" class="form-control">
											<?php
											if($p['hasil']=='Y'){
												?>
												<option value="Y" selected>Ada</option>
												<option value="N">Tidak Ada</option>
												<?php
											}
											else{
												?>
												<option value="Y">Ada</option>
												<option value="N" selected>Tidak Ada</option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-1">
										<input type="text" class="form-control" name="hasil1_d#<?php echo $r['id'];?>" placeholder="" value="<?php echo $p['hasil1'];?>">
									</div>
									
									<div class="col-md-2">
										Jam/hari, selama
									</div>
									
									<div class="col-md-1">
										<input type="text" class="form-control" name="hasil2_d#<?php echo $r['id'];?>" placeholder="" value="<?php echo $p['hasil2'];?>">
									</div>
									<div class="col-md-1">
										tahun
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="keterangan_d#<?php echo $r['id'];?>" placeholder="Keterangan" value="<?php echo $p['keterangan'];?>">
									</div>
								</div>
								<?php
								$no++;
							}
							?>
						</div>
						
						<p class="title-dark">Riwayat Kecelakaan Kerja</p>
						<?php
						$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_kk WHERE id_anamnesa='$id_anamnesa'"));
						?>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-1 form-control-label">1. </label>
								<div class="col-md-11">
									<input type="text" class="form-control" name="riwayat_e#1" placeholder="Riwayat" value="<?php echo $p['riwayat1'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-1 form-control-label">2. </label>
								<div class="col-md-11">
									<input type="text" class="form-control" name="riwayat_e#2" placeholder="Riwayat" value="<?php echo $p['riwayat2'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-1 form-control-label">3. </label>
								<div class="col-md-11">
									<input type="text" class="form-control" name="riwayat_e#3" placeholder="Riwayat" value="<?php echo $p['riwayat3'];?>">
								</div>
							</div>
						</div>
						
						<p class="title-dark">Kebiasaan</p>
						<div class="padding-20">
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_kebiasaan");
							$no=1;
							while($r=pg_fetch_array($tampil)){
								$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_kebiasaan WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_kebiasaan='$r[id]'"));
								?>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">
										<input type="checkbox" name="checked_f[]" value="<?php echo $r['id'];?>" checked>
										<?php echo "$no. $r[nama]";?>
									</label>
									<div class="col-md-2">
										<select name="hasil_f#<?php echo $r['id'];?>" class="form-control">
											<?php
											if($p['hasil']=='Y'){
												?>
												<option value="Y" selected>Ada</option>
												<option value="N">Tidak Ada</option>
												<?php
											}
											else{
												?>
												<option value="Y">Ada</option>
												<option value="N" selected>Tidak Ada</option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="hasil2_f#<?php echo $r['id'];?>" placeholder=""  value="<?php echo $p['hasil2'];?>">
									</div>
									
									<div class="col-md-2">
										<?php echo $r['satuan'];?>
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control" name="keterangan_f#<?php echo $r['id'];?>" placeholder="Keterangan" value="<?php echo $p['keterangan'];?>">
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
				$('#edit_pasien_anamesa').on('submit',(function(e) {
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
						url: 'data-pasien-anamnesa',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_anamnesa").html(msg);
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
						url: 'data-pasien-anamnesa',
						data: dataString2,
						success: function(msg){
							$("#data_anamnesa").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='anamnesa' AND $act=='update'){
		$id_anamnesa=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_anamnesa SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', keterangan='$_POST[keterangan]' WHERE id='$id_anamnesa'");
		
		/*keluhan saat ini*/
		pg_query($dbconn,"DELETE FROM pasien_anamnesa_ksi WHERE id_anamnesa='$id_anamnesa'");
		foreach($_POST['checked_a'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_a#'.$value];
			$keterangan=$_POST['keterangan_a#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_ksi (id_anamnesa, id_anamnesa_ksi, hasil, keterangan) VALUES ('$id_anamnesa', '$id', '$hasil', '$keterangan')");
		}
		
		/*riwayat penyakit dahulu*/
		pg_query($dbconn,"DELETE FROM pasien_anamnesa_rpd WHERE id_anamnesa='$id_anamnesa'");
		foreach($_POST['checked_b'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_b#'.$value];
			$hasil1=$_POST['hasil1_b#'.$value];
			$hasil2=$_POST['hasil2_b#'.$value];
			$keterangan=$_POST['keterangan_b#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_rpd (id_anamnesa, id_anamnesa_rpd, hasil, hasil1, hasil2, keterangan) VALUES ('$id_anamnesa', '$id', '$hasil', '$hasil1', '$hasil2', '$keterangan')");
		}
		
		/*riwayat penyakit keluarga*/
		pg_query($dbconn,"DELETE FROM pasien_anamnesa_rpk WHERE id_anamnesa='$id_anamnesa'");
		foreach($_POST['checked_c'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_c#'.$value];
			$keterangan=$_POST['keterangan_c#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_rpk (id_anamnesa, id_anamnesa_rpk, hasil, keterangan) VALUES ('$id_anamnesa', '$id', '$hasil', '$keterangan')");
		}
		
		/*riwayat hazard lingkungan kerja*/
		pg_query($dbconn,"DELETE FROM pasien_anamnesa_rhlk WHERE id_anamnesa='$id_anamnesa'");
		foreach($_POST['checked_d'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_d#'.$value];
			$hasil1=$_POST['hasil1_d#'.$value];
			$hasil2=$_POST['hasil2_d#'.$value];
			$keterangan=$_POST['keterangan_d#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_rhlk (id_anamnesa, id_anamnesa_rhlk, hasil, hasil1, hasil2, keterangan) VALUES ('$id_anamnesa', '$id', '$hasil', '$hasil1', '$hasil2', '$keterangan')");
		}
		
		/*riwayat lingkungan kerja*/
		$riwayat1=$_POST["riwayat_e#1"];
		$riwayat2=$_POST["riwayat_e#2"];
		$riwayat3=$_POST["riwayat_e#3"];
		pg_query($dbconn,"DELETE FROM pasien_anamnesa_kk WHERE id_anamnesa='$id_anamnesa'");
		
		pg_query($dbconn,"INSERT INTO pasien_anamnesa_kk (id_anamnesa, riwayat1, riwayat2, riwayat3) VALUES ('$id_anamnesa', '$riwayat1', '$riwayat2', '$riwayat3')");
		
		/*kebiasaan*/
		pg_query($dbconn,"DELETE FROM pasien_anamnesa_kebiasaan WHERE id_anamnesa='$id_anamnesa'");
		foreach($_POST['checked_f'] as $key => $value){
			$id=$value;
			$hasil=$_POST['hasil_f#'.$value];
			$hasil2=$_POST['hasil2_f#'.$value];
			$keterangan=$_POST['keterangan_f#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_anamnesa_kebiasaan (id_anamnesa, id_anamnesa_kebiasaan, hasil, hasil2, keterangan) VALUES ('$id_anamnesa', '$id', '$hasil', '$hasil2', '$keterangan')");
		}
	}
	
	elseif ($module=='anamnesa' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_anamnesa SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	elseif ($module=='anamnesa' AND $act=='view'){
		$r=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa WHERE id='$_POST[id]'"));
		$id_anamnesa=$r['id'];
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
			<strong>View Anamnesa</strong>
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
								<td>Keterangan</td>
								<td>:</td>
								<td><?php echo $r['keterangan'];?></td>
							</tr>
						</table>
					</div>
					
					<table class="table">
						<thead>
							<tr>
								<th colspan="2">Item Pemeriksaan</th>
								<th>Hasil</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="4"><b>Riwayat Kesehatan</b></td>
							</tr>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_ksi");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_ksi WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_ksi='$r[id]'"));
									?>
									<tr>
										<td></td>
										<td><?php echo $r['nama'];?></td>
										<td><?php echo $p['hasil'];?></td>
										<td><?php echo $p['keterangan'];?></td>
									</tr>
									<?php
								}
							?>
							
							<tr>
								<td colspan="4"><b>Riwayat Kesehatan Dahulu</b></td>
							</tr>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_rpd");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_rpd WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_rpd='$r[id]'"));
									if($p['hasil']=='Y'){
										$hasil="Ada";
									}
									else{
										$hasil="Tidak Ada";
									}
									
									if($r['id']<3){
										$hasil1=$p['hasil1'];
									}
									elseif($r['id']=3){
										if($p['hasil1']!=''){
											$hasil1="tulang $p[hasil1]";
										}
									}
									elseif($r['id']=4){
										if($p['hasil1']!=''){
											$hasil1="selama $p[hasil1] Bulan, pada tahun $p[hasil2]";
										}
									}
									
									
									if($hasil1!=''){
										$hasil="$hasil - $hasil1";
									}
									?>
									<tr>
										<td></td>
										<td><?php echo $r['nama'];?></td>
										<td><?php echo $hasil;?></td>
										<td><?php echo $p['keterangan'];?></td>
									</tr>
									<?php
								}
							?>
							
							<tr>
								<td colspan="4"><b>Riwayat Kesehatan Keluarga</b></td>
							</tr>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_rpk");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_rpk WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_rpk='$r[id]'"));
									if($p['hasil']=='Y'){
										$hasil="Ada";
									}
									else{
										$hasil="Tidak Ada";
									}
									
									?>
									<tr>
										<td></td>
										<td><?php echo $r['nama'];?></td>
										<td><?php echo $hasil;?></td>
										<td><?php echo $p['keterangan'];?></td>
									</tr>
									<?php
								}
							?>
							
							<tr>
								<td colspan="4"><b>Riwayat Hazard Lingkungan Kerja</b></td>
							</tr>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_rhlk");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_rhlk WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_rhlk='$r[id]'"));
									if($p['hasil']=='Y'){
										$hasil = "Ada, $p[hasil1] jam/hari, selama $p[hasil2] tahun";
									}
									else{
										$hasil="Tidak Ada";
									}
									
									?>
									<tr>
										<td></td>
										<td><?php echo $r['nama'];?></td>
										<td><?php echo $hasil;?></td>
										<td><?php echo $p['keterangan'];?></td>
									</tr>
									<?php
								}
							?>
							
							<tr>
								<td colspan="4"><b>Riwayat Kecelakaan Kerja</b></td>
							</tr>
							<?php
								$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_kk WHERE id_anamnesa='$id_anamnesa'"));
								if($p['riwayat1']!=''){
									?>
									<tr>
										<td></td>
										<td></td>
										<td colspan="2">1. <?php echo $p['riwayat1'];?></td>
									</tr>
									<?php
								}
								if($p['riwayat2']!=''){
									?>
									<tr>
										<td></td>
										<td></td>
										<td colspan="2">2. <?php echo $p['riwayat2'];?></td>
									</tr>
									<?php
								}
								if($p['riwayat3']!=''){
									?>
									<tr>
										<td></td>
										<td></td>
										<td colspan="2">3. <?php echo $p['riwayat3'];?></td>
									</tr>
									<?php
								}
							?>
							
							<tr>
								<td colspan="4"><b>Kebiasaan</b></td>
							</tr>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_kebiasaan");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_anamnesa_kebiasaan WHERE id_anamnesa='$id_anamnesa' AND id_anamnesa_kebiasaan='$r[id]'"));
									if($p['hasil']=='Y'){
										$hasil = "Ada, $p[hasil2] $r[satuan]";
									}
									else{
										$hasil="Tidak Ada";
									}
									
									?>
									<tr>
										<td></td>
										<td><?php echo $r['nama'];?></td>
										<td><?php echo $hasil;?></td>
										<td><?php echo $p['keterangan'];?></td>
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
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
						url: 'data-pasien-anamnesa',
						data: dataString2,
						success: function(msg){
							$("#data_anamnesa").html(msg);
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