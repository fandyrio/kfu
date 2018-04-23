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
	if ($module=='mulut' AND $act=='data_mulut'){
		$id_pasien=$_POST['id_pasien'];
		$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
		$id_kunjungan=$a['id_kunjungan'];
		?>
		<div class="card-header">
			<strong>Pemeriksaan Mulut</strong>
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
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_mulut WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
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
						url: 'form-tambah-pasien-mulut',
						data: dataString2,
						success: function(msg){
							$("#data_mulut").html(msg);
						}
					});
				});
				
				$(".btnEdit").click(function(){
					var id = this.id;
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-mulut',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_mulut").html(msg);
						}
					});
				});
				
				$(".btnHapus").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus mulut ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-mulut',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_mulut").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-mulut',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_mulut").html(msg);
								alert("mulut berhasil dihapus");
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
						url: 'view-pasien-mulut',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_mulut").html(msg);
						}
					});
				});
			});
			</script>
		<?php
	}
	
	elseif ($module=='mulut' AND $act=='inputform'){
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien_mulut" class="form-horizontal" action="aksi-tambah-pasien-mulut" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<div class="card-header">
			<strong>Tambah Pemeriksaan Mulut</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<p class="title-dark">Pemeriksaan Mulut</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-2 form-control-label">1. Oral Hygiene</label>
							</div>
							<div class="form-group row">
								<div class="col-md-2">
									<select name="oral_hasil" class="form-control">
										<option value="1">Baik</option>
										<option value="2">Cukup</option>
										<option value="3">Kurang</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="oral_keterangan" placeholder="Keterangan">
								</div>
							</div>

							<div class="form-group row">							
								<label class="col-md-2 form-control-label">2. Lidah</label>
							</div>
							<div class="form-group row">
								
								<div class="col-md-2">
									<select name="lidah_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="lidah_keterangan" placeholder="Keterangan">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">3. Gusi</label>
							</div>

							<div class="form-group row">
								<div class="col-md-2">
									<select name="lidah_hasil" class="form-control">
										<option value="1">Normal</option>
										<option value="2">Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="lidah_keterangan" placeholder="Keterangan">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">4. Gigi</label>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<table class="table table-bordered">
										<tr>
											<td colspan="8" class="text-center">Kiri Atas</td>
											<td colspan="8" class="text-center">Kanan Atas</td>
										</tr>
										<tr>
											<td><input type="text" name="gigi_a1" class="form-control" placeholder="M3"></td>
											<td><input type="text" name="gigi_a2" class="form-control" placeholder="M2"></td>
											<td><input type="text" name="gigi_a3" class="form-control" placeholder="M1"></td>
											<td><input type="text" name="gigi_a4" class="form-control" placeholder="P2"></td>
											<td><input type="text" name="gigi_a5" class="form-control" placeholder="P1"></td>
											<td><input type="text" name="gigi_a6" class="form-control" placeholder="C1"></td>
											<td><input type="text" name="gigi_a7" class="form-control" placeholder="I2"></td>
											<td><input type="text" name="gigi_a8" class="form-control" placeholder="I1"></td>
											<td><input type="text" name="gigi_b1" class="form-control" placeholder="I1"></td>
											<td><input type="text" name="gigi_b2" class="form-control" placeholder="I2"></td>
											<td><input type="text" name="gigi_b3" class="form-control" placeholder="C1"></td>
											<td><input type="text" name="gigi_b4" class="form-control" placeholder="P1"></td>
											<td><input type="text" name="gigi_b5" class="form-control" placeholder="P2"></td>
											<td><input type="text" name="gigi_b6" class="form-control" placeholder="M1"></td>
											<td><input type="text" name="gigi_b7" class="form-control" placeholder="M2"></td>
											<td><input type="text" name="gigi_b8" class="form-control" placeholder="M3"></td>
										</tr>
										<tr>
											<td colspan="8" class="text-center">Kiri Bawah</td>
											<td colspan="8" class="text-center">Kanan Bawah</td>
										</tr>
										<tr>
											<td><input type="text" name="gigi_c1" class="form-control" placeholder="M3"></td>
											<td><input type="text" name="gigi_c2" class="form-control" placeholder="M2"></td>
											<td><input type="text" name="gigi_c3" class="form-control" placeholder="M1"></td>
											<td><input type="text" name="gigi_c4" class="form-control" placeholder="P2"></td>
											<td><input type="text" name="gigi_c5" class="form-control" placeholder="P1"></td>
											<td><input type="text" name="gigi_c6" class="form-control" placeholder="C1"></td>
											<td><input type="text" name="gigi_c7" class="form-control" placeholder="I2"></td>
											<td><input type="text" name="gigi_c8" class="form-control" placeholder="I1"></td>
											<td><input type="text" name="gigi_d1" class="form-control" placeholder="I1"></td>
											<td><input type="text" name="gigi_d2" class="form-control" placeholder="I2"></td>
											<td><input type="text" name="gigi_d3" class="form-control" placeholder="C1"></td>
											<td><input type="text" name="gigi_d4" class="form-control" placeholder="P1"></td>
											<td><input type="text" name="gigi_d5" class="form-control" placeholder="P2"></td>
											<td><input type="text" name="gigi_d6" class="form-control" placeholder="M1"></td>
											<td><input type="text" name="gigi_d7" class="form-control" placeholder="M2"></td>
											<td><input type="text" name="gigi_d8" class="form-control" placeholder="M3"></td>
										</tr>
									</table>
								</div>
								<div class="col-md-4">
									<textarea name="gigi_keterangan" class="form-control" placeholder="Keterangan"></textarea>
								</div>
							</div>
							
							<div class="form-group row">							
								<label class="col-md-2 form-control-label">5. Keterangan/Catatan</label>
							</div>
							<div class="form-group row">
								<div class="col-md-10">
									<textarea name="keterangan" class="form-control"></textarea>
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
			$('#tambah_pasien_mulut').on('submit',(function(e) {
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
					url: 'data-pasien-mulut',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#data_mulut").html(msg);
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
					url: 'data-pasien-mulut',
					data: dataString2,
					success: function(msg){
						$("#data_mulut").html(msg);
					}
				});
			});
		});
		</script>
		<?php
	}
	
	elseif ($module=='mulut' AND $act=='input'){
		/*mulut*/
		pg_query($dbconn,"INSERT INTO pasien_mulut (id_pasien, id_kunjungan, id_unit, waktu_input, status_hapus, id_user, oral_hasil, oral_keterangan, lidah_hasil, lidah_keterangan, gusi_hasil, gusi_keterangan, gigi_a1, gigi_a2, gigi_a3, gigi_a4, gigi_a5, gigi_a6, gigi_a7, gigi_a8, gigi_b1, gigi_b2, gigi_b3, gigi_b4, gigi_b5, gigi_b6, gigi_b7, gigi_b8, gigi_c1, gigi_c2, gigi_c3, gigi_c4, gigi_c5, gigi_c6, gigi_c7, gigi_c8, gigi_d1, gigi_d2, gigi_d3, gigi_d4, gigi_d5, gigi_d6, gigi_d7, gigi_d8, gigi_keterangan, keterangan) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', '$_SESSION[id_units]', '$tgl_sekarang $jam_sekarang', 'N', '$_SESSION[login_user]', '$_POST[oral_hasil]', '$_POST[oral_keterangan]', '$_POST[lidah_hasil]', '$_POST[lidah_keterangan]', '$_POST[gusi_hasil]', '$_POST[gusi_keterangan]', '$_POST[gigi_a1]', '$_POST[gigi_a2]', '$_POST[gigi_a3]', '$_POST[gigi_a4]', '$_POST[gigi_a5]', '$_POST[gigi_a6]', '$_POST[gigi_a7]', '$_POST[gigi_a8]', '$_POST[gigi_b1]', '$_POST[gigi_b2]', '$_POST[gigi_b3]', '$_POST[gigi_b4]', '$_POST[gigi_b5]', '$_POST[gigi_b6]', '$_POST[gigi_b7]', '$_POST[gigi_b8]', '$_POST[gigi_c1]', '$_POST[gigi_c2]', '$_POST[gigi_c3]', '$_POST[gigi_c4]', '$_POST[gigi_c5]', '$_POST[gigi_c6]', '$_POST[gigi_c7]', '$_POST[gigi_c8]', '$_POST[gigi_d1]', '$_POST[gigi_d2]', '$_POST[gigi_d3]', '$_POST[gigi_d4]', '$_POST[gigi_d5]', '$_POST[gigi_d6]', '$_POST[gigi_d7]', '$_POST[gigi_d8]', '$_POST[gigi_keterangan]', '$_POST[keterangan]')");
		
	}
	
	elseif ($module=='mulut' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_mulut WHERE id='$_POST[id]'"));
		$id_mulut=$d['id'];
		?>
		<form id="edit_pasien_mulut" class="form-horizontal" action="aksi-edit-pasien-mulut" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_mulut">
			<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
			<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
			<div class="card-header">
				<strong>Edit Pemeriksaan Mulut</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<p class="title-dark">Pemeriksaan Mulut</p>
						<div class="padding-20">
							<div class="form-group row">
								<label class="col-md-2 form-control-label">1. Oral Hygiene</label>
								<div class="col-md-2">
									<select name="oral_hasil" class="form-control">
										<option value="1" <?php if($d['oral_hasil']==1) echo "selected";?>>Baik</option>
										<option value="2" <?php if($d['oral_hasil']==2) echo "selected";?>>Cukup</option>
										<option value="3" <?php if($d['oral_hasil']==3) echo "selected";?>>Kurang</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="oral_keterangan" placeholder="Keterangan" value="<?php echo $d['oral_keterangan'];?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">2. Lidah</label>
								<div class="col-md-2">
									<select name="lidah_hasil" class="form-control">
										<option value="1" <?php if($d['lidah_hasil']==1) echo "selected";?>>Normal</option>
										<option value="2" <?php if($d['lidah_hasil']==2) echo "selected";?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="lidah_keterangan" placeholder="Keterangan" value="<?php echo $d['lidah_keterangan'];?>">
								</div>
							</div>
							
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">3. Gusi</label>
								<div class="col-md-2">
									<select name="gusi_hasil" class="form-control">
										<option value="1" <?php if($d['gusi_hasil']==1) echo "selected";?>>Normal</option>
										<option value="2" <?php if($d['gusi_hasil']==2) echo "selected";?>>Tidak Normal</option>
									</select>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="gusi_keterangan" placeholder="Keterangan" value="<?php echo $d['gusi_keterangan'];?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-2 form-control-label">4. Gigi</label>
							</div>
							<div class="form-group row">
								
								<div class="col-md-12">
									<table class="table table-bordered">
										<tr>
											<td colspan="8" class="text-center">Kiri Atas</td>
											<td colspan="8" class="text-center">Kanan Atas</td>
										</tr>
										<tr>
											<td><input type="text" name="gigi_a1" class="form-control" value="<?php echo $d['gigi_a1'];?>"></td>
											<td><input type="text" name="gigi_a2" class="form-control" value="<?php echo $d['gigi_a2'];?>"></td>
											<td><input type="text" name="gigi_a3" class="form-control" value="<?php echo $d['gigi_a3'];?>"></td>
											<td><input type="text" name="gigi_a4" class="form-control" value="<?php echo $d['gigi_a4'];?>"></td>
											<td><input type="text" name="gigi_a5" class="form-control" value="<?php echo $d['gigi_a5'];?>"></td>
											<td><input type="text" name="gigi_a6" class="form-control" value="<?php echo $d['gigi_a6'];?>"></td>
											<td><input type="text" name="gigi_a7" class="form-control" value="<?php echo $d['gigi_a7'];?>"></td>
											<td><input type="text" name="gigi_a8" class="form-control" value="<?php echo $d['gigi_a8'];?>"></td>
											<td><input type="text" name="gigi_b1" class="form-control" value="<?php echo $d['gigi_b1'];?>"></td>
											<td><input type="text" name="gigi_b2" class="form-control" value="<?php echo $d['gigi_b2'];?>"></td>
											<td><input type="text" name="gigi_b3" class="form-control" value="<?php echo $d['gigi_b3'];?>"></td>
											<td><input type="text" name="gigi_b4" class="form-control" value="<?php echo $d['gigi_b4'];?>"></td>
											<td><input type="text" name="gigi_b5" class="form-control" value="<?php echo $d['gigi_b5'];?>"></td>
											<td><input type="text" name="gigi_b6" class="form-control" value="<?php echo $d['gigi_b6'];?>"></td>
											<td><input type="text" name="gigi_b7" class="form-control" value="<?php echo $d['gigi_b7'];?>"></td>
											<td><input type="text" name="gigi_b8" class="form-control" value="<?php echo $d['gigi_b8'];?>"></td>
										</tr>
										<tr>
											<td colspan="8" class="text-center">Kiri Bawah</td>
											<td colspan="8" class="text-center">Kanan Bawah</td>
										</tr>
										<tr>
											<td><input type="text" name="gigi_c1" class="form-control" value="<?php echo $d['gigi_c1'];?>"></td>
											<td><input type="text" name="gigi_c2" class="form-control" value="<?php echo $d['gigi_c2'];?>"></td>
											<td><input type="text" name="gigi_c3" class="form-control" value="<?php echo $d['gigi_c3'];?>"></td>
											<td><input type="text" name="gigi_c4" class="form-control" value="<?php echo $d['gigi_c4'];?>"></td>
											<td><input type="text" name="gigi_c5" class="form-control" value="<?php echo $d['gigi_c5'];?>"></td>
											<td><input type="text" name="gigi_c6" class="form-control" value="<?php echo $d['gigi_c6'];?>"></td>
											<td><input type="text" name="gigi_c7" class="form-control" value="<?php echo $d['gigi_c7'];?>"></td>
											<td><input type="text" name="gigi_c8" class="form-control" value="<?php echo $d['gigi_c8'];?>"></td>
											<td><input type="text" name="gigi_d1" class="form-control" value="<?php echo $d['gigi_d1'];?>"></td>
											<td><input type="text" name="gigi_d2" class="form-control" value="<?php echo $d['gigi_d2'];?>"></td>
											<td><input type="text" name="gigi_d3" class="form-control" value="<?php echo $d['gigi_d3'];?>"></td>
											<td><input type="text" name="gigi_d4" class="form-control" value="<?php echo $d['gigi_d4'];?>"></td>
											<td><input type="text" name="gigi_d5" class="form-control" value="<?php echo $d['gigi_d5'];?>"></td>
											<td><input type="text" name="gigi_d6" class="form-control" value="<?php echo $d['gigi_d6'];?>"></td>
											<td><input type="text" name="gigi_d7" class="form-control" value="<?php echo $d['gigi_d7'];?>"></td>
											<td><input type="text" name="gigi_d8" class="form-control" value="<?php echo $d['gigi_d8'];?>"></td>
										</tr>
									</table>
								</div>
								<div class="col-md-2">
									<textarea name="gigi_keterangan" class="form-control" placeholder="Keterangan"><?php echo $d['gigi_keterangan'];?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-2 form-control-label">4. Keterangan/Catatan</label>
								<div class="col-md-10">
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
				$('#edit_pasien_mulut').on('submit',(function(e) {
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
						url: 'data-pasien-mulut',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_mulut").html(msg);
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
						url: 'data-pasien-mulut',
						data: dataString2,
						success: function(msg){
							$("#data_mulut").html(msg);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='mulut' AND $act=='update'){
		$id_mulut=$_POST['id'];
		pg_query($dbconn,"UPDATE pasien_mulut SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', keterangan='$_POST[keterangan]', oral_hasil='$_POST[oral_hasil]', oral_keterangan='$_POST[oral_keterangan]', lidah_hasil='$_POST[lidah_hasil]', lidah_keterangan='$_POST[lidah_keterangan]', gusi_hasil='$_POST[gusi_hasil]', gusi_keterangan='$_POST[gusi_keterangan]', gigi_a1='$_POST[gigi_a1]', gigi_a2='$_POST[gigi_a2]', gigi_a3='$_POST[gigi_a3]', gigi_a4='$_POST[gigi_a4]', gigi_a5='$_POST[gigi_a5]', gigi_a6='$_POST[gigi_a6]', gigi_a7='$_POST[gigi_a7]', gigi_a8='$_POST[gigi_a8]', gigi_b1='$_POST[gigi_b1]', gigi_b2='$_POST[gigi_b2]', gigi_b3='$_POST[gigi_b3]', gigi_b4='$_POST[gigi_b4]', gigi_b5='$_POST[gigi_b5]', gigi_b6='$_POST[gigi_b6]', gigi_b7='$_POST[gigi_b7]', gigi_b8='$_POST[gigi_b8]', gigi_c1='$_POST[gigi_c1]', gigi_c2='$_POST[gigi_c2]', gigi_c3='$_POST[gigi_c3]', gigi_c4='$_POST[gigi_c4]', gigi_c5='$_POST[gigi_c5]', gigi_c6='$_POST[gigi_c6]', gigi_c7='$_POST[gigi_c7]', gigi_c8='$_POST[gigi_c8]', gigi_d1='$_POST[gigi_d1]', gigi_d2='$_POST[gigi_d2]', gigi_d3='$_POST[gigi_d3]', gigi_d4='$_POST[gigi_d4]', gigi_d5='$_POST[gigi_d5]', gigi_d6='$_POST[gigi_d6]', gigi_d7='$_POST[gigi_d7]', gigi_d8='$_POST[gigi_d8]', gigi_keterangan='$_POST[gigi_keterangan]' WHERE id='$id_mulut'");
		
	}
	
	elseif ($module=='mulut' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_mulut SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	elseif ($module=='mulut' AND $act=='view'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_mulut WHERE id='$_POST[id]'"));
		$id_mulut=$d['id'];
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
			<strong>View Pemeriksaan Mulut</strong>
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
					<p class="title-dark">Pemeriksaan Mulut</p>
					<div class="padding-20">
						<div class="form-group row">
							<label class="col-md-2 form-control-label">1. Oral Hygiene</label>
							<div class="col-md-10">: 
								<?php
								if($d['oral_hasil']==1){
									echo"Baik";
								}
								elseif($d['oral_hasil']==2){
									echo"Cukup";
								}
								elseif($d['oral_hasil']==3){
									echo"Kurang";
								}
								if($d['oral_keterangan']!=''){
									echo" ($d[oral_keterangan])";
								}
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">2. Lidah</label>
							<div class="col-md-10">: 
								<?php 
								if($d['lidah_hasil']==1){
									echo"Normal";
								}
								else{
									echo"Tidak Normal";
								}
								echo " ($d[lidah_keterangan])";
								?>
							</div>
						</div>
						
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">3. Gusi</label>
							<div class="col-md-10">: 
								<?php 
								if($d['gusi_hasil']==1){
									echo"Normal";
								}
								else{
									echo"Tidak Normal";
								}
								echo " ($d[gusi_keterangan])";
								?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2 form-control-label">4. Gigi</label>
							<div class="col-md-8">
								<table class="table table-bordered">
									<tr>
										<td colspan="8" class="text-center">Kiri Atas</td>
										<td colspan="8" class="text-center">Kanan Atas</td>
									</tr>
									<tr>
										<td><input type="text" name="gigi_a1" class="form-control" value="<?php echo $d['gigi_a1'];?>" readonly></td>
										<td><input type="text" name="gigi_a2" class="form-control" value="<?php echo $d['gigi_a2'];?>" readonly></td>
										<td><input type="text" name="gigi_a3" class="form-control" value="<?php echo $d['gigi_a3'];?>" readonly></td>
										<td><input type="text" name="gigi_a4" class="form-control" value="<?php echo $d['gigi_a4'];?>" readonly></td>
										<td><input type="text" name="gigi_a5" class="form-control" value="<?php echo $d['gigi_a5'];?>" readonly></td>
										<td><input type="text" name="gigi_a6" class="form-control" value="<?php echo $d['gigi_a6'];?>" readonly></td>
										<td><input type="text" name="gigi_a7" class="form-control" value="<?php echo $d['gigi_a7'];?>" readonly></td>
										<td><input type="text" name="gigi_a8" class="form-control" value="<?php echo $d['gigi_a8'];?>" readonly></td>
										<td><input type="text" name="gigi_b1" class="form-control" value="<?php echo $d['gigi_b1'];?>" readonly></td>
										<td><input type="text" name="gigi_b2" class="form-control" value="<?php echo $d['gigi_b2'];?>" readonly></td>
										<td><input type="text" name="gigi_b3" class="form-control" value="<?php echo $d['gigi_b3'];?>" readonly></td>
										<td><input type="text" name="gigi_b4" class="form-control" value="<?php echo $d['gigi_b4'];?>" readonly></td>
										<td><input type="text" name="gigi_b5" class="form-control" value="<?php echo $d['gigi_b5'];?>" readonly></td>
										<td><input type="text" name="gigi_b6" class="form-control" value="<?php echo $d['gigi_b6'];?>" readonly></td>
										<td><input type="text" name="gigi_b7" class="form-control" value="<?php echo $d['gigi_b7'];?>" readonly></td>
										<td><input type="text" name="gigi_b8" class="form-control" value="<?php echo $d['gigi_b8'];?>" readonly></td>
									</tr>
									<tr>
										<td colspan="8" class="text-center">Kiri Bawah</td>
										<td colspan="8" class="text-center">Kanan Bawah</td>
									</tr>
									<tr>
										<td><input type="text" name="gigi_c1" class="form-control" value="<?php echo $d['gigi_c1'];?>" readonly></td>
										<td><input type="text" name="gigi_c2" class="form-control" value="<?php echo $d['gigi_c2'];?>" readonly></td>
										<td><input type="text" name="gigi_c3" class="form-control" value="<?php echo $d['gigi_c3'];?>" readonly></td>
										<td><input type="text" name="gigi_c4" class="form-control" value="<?php echo $d['gigi_c4'];?>" readonly></td>
										<td><input type="text" name="gigi_c5" class="form-control" value="<?php echo $d['gigi_c5'];?>" readonly></td>
										<td><input type="text" name="gigi_c6" class="form-control" value="<?php echo $d['gigi_c6'];?>" readonly></td>
										<td><input type="text" name="gigi_c7" class="form-control" value="<?php echo $d['gigi_c7'];?>" readonly></td>
										<td><input type="text" name="gigi_c8" class="form-control" value="<?php echo $d['gigi_c8'];?>" readonly></td>
										<td><input type="text" name="gigi_d1" class="form-control" value="<?php echo $d['gigi_d1'];?>" readonly></td>
										<td><input type="text" name="gigi_d2" class="form-control" value="<?php echo $d['gigi_d2'];?>" readonly></td>
										<td><input type="text" name="gigi_d3" class="form-control" value="<?php echo $d['gigi_d3'];?>" readonly></td>
										<td><input type="text" name="gigi_d4" class="form-control" value="<?php echo $d['gigi_d4'];?>" readonly></td>
										<td><input type="text" name="gigi_d5" class="form-control" value="<?php echo $d['gigi_d5'];?>" readonly></td>
										<td><input type="text" name="gigi_d6" class="form-control" value="<?php echo $d['gigi_d6'];?>" readonly></td>
										<td><input type="text" name="gigi_d7" class="form-control" value="<?php echo $d['gigi_d7'];?>" readonly></td>
										<td><input type="text" name="gigi_d8" class="form-control" value="<?php echo $d['gigi_d8'];?>" readonly></td>
									</tr>
								</table>
							</div>
							<div class="col-md-2">
								<textarea name="gigi_keterangan" class="form-control" placeholder="Keterangan" readonly><?php echo $d['gigi_keterangan'];?></textarea>
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
						url: 'data-pasien-mulut',
						data: dataString2,
						success: function(msg){
							$("#data_mulut").html(msg);
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