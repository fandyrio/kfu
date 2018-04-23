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
	if ($module=='lain' AND $act=='data_lain'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Pemeriksaan Lainnya</strong>
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
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_lain WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
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
						url: 'form-tambah-pasien-lain',
						data: dataString2,
						success: function(msg){
							$("#data_lain").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-lain',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_lain").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus lain ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-lain',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_lain").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-lain',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_lain").html(msg);
								alert("lain berhasil dihapus");
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
						url: 'view-pasien-lain',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_lain").html(msg);
						}
					});
				});
			});
			</script>
		<?php
	}
	
	elseif ($module=='lain' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_lain" class="form-horizontal" action="aksi-tambah-pasien-lain" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Pemeriksaan Lainnya</strong>
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
					<p class="title-dark">Pemeriksaan Lainnya</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-3 form-control-label">1. HPHT</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="lain1_keterangan" placeholder="">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">2. Lingkar Perut (cm)</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="lain2_keterangan" placeholder="">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">3. Lingkar Lengan Atas (cm)</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="lain3_keterangan" placeholder="">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">4. Pemeriksaan Payudara</label>
							<div class="col-md-8">
								<textarea name="lain4_keterangan" class="form-control" placeholder=""></textarea>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">5. Riwayat Epilepsi</label>
							<div class="col-md-8">
								<textarea name="lain5_keterangan" class="form-control" placeholder=""></textarea>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">6. Riwayat Schizophernia termasuk Demensia</label>
							<div class="col-md-8">
								<textarea name="lain6_keterangan" class="form-control" placeholder=""></textarea>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">7. Starbismus (Mata Juling)</label>
							<div class="col-md-8">
								<textarea name="lain7_keterangan" class="form-control" placeholder=""></textarea>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">8. Amputasi satu/dua lengan atau satu/dua tungkai di bawah lutut</label>
							<div class="col-md-8">
								<textarea name="lain8_keterangan" class="form-control" placeholder=""></textarea>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">9. Paralisis atau Deformitas extremitas</label>
							<div class="col-md-8">
								<textarea name="lain9_keterangan" class="form-control" placeholder=""></textarea>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">10. Paraplegia atau Kuadriplegia</label>
							<div class="col-md-8">
								<textarea name="lain10_keterangan" class="form-control" placeholder=""></textarea>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">11. Hemiplegi</label>
							<div class="col-md-8">
								<textarea name="lain11_keterangan" class="form-control" placeholder=""></textarea>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label">12. Adnexitis</label>
							<div class="col-md-8">
								<textarea name="lain12_keterangan" class="form-control" placeholder=""></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-3 form-control-label">13. Denyut nadi (Arteri) Perifer</label>
							<div class="col-md-8">
								<textarea name="lain13_keterangan" class="form-control" placeholder=""></textarea>
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
			$('#tambah_pasien_lain').on('submit',(function(e) {
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
					url: 'data-pasien-lain',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_lain").html(msg);
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
					url: 'data-pasien-lain',
					data: dataString2,
					success: function(msg){
						$("#data_lain").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='lain' AND $act=='input'){
		/*lain*/
		pg_query($dbconn,"INSERT INTO pasien_lain (id_pasien, id_kunjungan, id_unit, waktu_input, status_hapus, id_user, lain1_keterangan, lain2_keterangan, lain3_keterangan, lain4_keterangan, lain5_keterangan, lain6_keterangan, lain7_keterangan, lain8_keterangan, lain9_keterangan, lain10_keterangan, lain11_keterangan, lain12_keterangan, lain13_keterangan, keterangan) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', '$_SESSION[id_units]', '$tgl_sekarang $jam_sekarang', 'N', '$_SESSION[login_user]', '$_POST[lain1_keterangan]', '$_POST[lain2_keterangan]', '$_POST[lain3_keterangan]', '$_POST[lain4_keterangan]', '$_POST[lain5_keterangan]', '$_POST[lain6_keterangan]', '$_POST[lain7_keterangan]', '$_POST[lain8_keterangan]', '$_POST[lain9_keterangan]', '$_POST[lain10_keterangan]', '$_POST[lain11_keterangan]', '$_POST[lain12_keterangan]','$_POST[lain13_keterangan]', '$_POST[keterangan]')");
		
	}
	
	elseif ($module=='lain' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_lain WHERE id='$_POST[id]'"));
		$id_lain=$d['id'];
		?>
		<form id="edit_pasien_lain" class="form-horizontal" action="aksi-edit-pasien-lain" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_lain">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Pemeriksaan Lainnya</strong>
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
						<p class="title-dark">Pemeriksaan Lainnya</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-3 form-control-label">1. HPHT</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="lain1_keterangan" placeholder="" value="<?php echo $d['lain1_keterangan'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">2. Lingkar Perut (cm)</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="lain2_keterangan" placeholder="" value="<?php echo $d['lain2_keterangan'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">3. Lingkar Lengan Atas (cm)</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="lain3_keterangan" placeholder="" value="<?php echo $d['lain3_keterangan'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">4. Pemeriksaan Payudara</label>
								<div class="col-md-8">
									<textarea name="lain4_keterangan" class="form-control" placeholder=""><?php echo $d['lain4_keterangan'];?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">5. Riwayat Epilepsi</label>
								<div class="col-md-8">
									<textarea name="lain5_keterangan" class="form-control" placeholder=""><?php echo $d['lain5_keterangan'];?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">6. Riwayat Schizophernia termasuk Demensia</label>
								<div class="col-md-8">
									<textarea name="lain6_keterangan" class="form-control" placeholder=""><?php echo $d['lain6_keterangan'];?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">7. Starbismus (Mata Juling)</label>
								<div class="col-md-8">
									<textarea name="lain7_keterangan" class="form-control" placeholder=""><?php echo $d['lain7_keterangan'];?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">8. Amputasi satu/dua lengan atau satu/dua tungkai di bawah lutut</label>
								<div class="col-md-8">
									<textarea name="lain8_keterangan" class="form-control" placeholder=""><?php echo $d['lain8_keterangan'];?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">9. Paralisis atau Deformitas extremitas</label>
								<div class="col-md-8">
									<textarea name="lain9_keterangan" class="form-control" placeholder=""><?php echo $d['lain9_keterangan'];?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">10. Paraplegia atau Kuadriplegia</label>
								<div class="col-md-8">
									<textarea name="lain10_keterangan" class="form-control" placeholder=""><?php echo $d['lain10_keterangan'];?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">11. Hemiplegi</label>
								<div class="col-md-8">
									<textarea name="lain11_keterangan" class="form-control" placeholder=""><?php echo $d['lain11_keterangan'];?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 form-control-label">12. Adnexitis</label>
								<div class="col-md-8">
									<textarea name="lain12_keterangan" class="form-control" placeholder=""><?php echo $d['lain12_keterangan'];?></textarea>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-3 form-control-label">13. Denyut nadi (Arteri) Perifer</label>
								<div class="col-md-8">
									<textarea name="lain13_keterangan" class="form-control" placeholder=""><?php echo $d['lain13_keterangan'];?></textarea>
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
				$('#edit_pasien_lain').on('submit',(function(e) {
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
						url: 'data-pasien-lain',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_lain").html(msg);
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
						url: 'data-pasien-lain',
						data: dataString2,
						success: function(msg){
							$("#data_lain").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='lain' AND $act=='update'){
		$id_lain=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_lain SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', keterangan='$_POST[keterangan]', lain1_keterangan='$_POST[lain1_keterangan]', lain2_keterangan='$_POST[lain2_keterangan]', lain3_keterangan='$_POST[lain3_keterangan]', lain4_keterangan='$_POST[lain4_keterangan]', lain5_keterangan='$_POST[lain5_keterangan]', lain6_keterangan='$_POST[lain6_keterangan]', lain7_keterangan='$_POST[lain7_keterangan]', lain8_keterangan='$_POST[lain8_keterangan]', lain9_keterangan='$_POST[lain9_keterangan]', lain10_keterangan='$_POST[lain10_keterangan]', lain11_keterangan='$_POST[lain11_keterangan]', lain12_keterangan='$_POST[lain12_keterangan]', lain13_keterangan='$_POST[lain13_keterangan]' WHERE id='$id_lain'");
		
	}
	
	elseif ($module=='lain' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_lain SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	elseif ($module=='lain' AND $act=='view'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_lain WHERE id='$_POST[id]'"));
		$id_lain=$d['id'];
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
			<strong>View Pemeriksaan Lainnya</strong>
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
					
					<p class="title-dark">Pemeriksaan Lainnya</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-4 form-control-label">1. HPHT</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain1_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">2. Lingkar Perut</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain2_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">3. Lingkar Lengan Atas</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain3_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">4. Pemeriksaan Payudara</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain4_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">5. Riwayat Epilepsi</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain5_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">6. Riwayat Schizophernia termasuk Deformitas</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain6_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">7. Starbismus (Mata Juling)</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain7_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">8. Amputasi satu/dua lengan atau satu/dua tungkai di bawah lutut</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain8_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">9. Paralisis atau Deformitas extremitas</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain9_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">10. Paraplegia atau Kuadriplegia</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain10_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">11. Hemiplegi</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain11_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label">12. Adnexitis</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain12_keterangan])";
								?>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 form-control-label">13. Denyut nadi (Arteri) Perifer</label>
							<div class="col-md-8">
								: 
								<?php
								echo " ($d[lain13_keterangan])";
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
						url: 'data-pasien-lain',
						data: dataString2,
						success: function(msg){
							$("#data_lain").html(msg);
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