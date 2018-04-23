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
	
	if ($module=='peringatan' AND $act=='data_peringatan'){
		$id_pasien=$_POST['id_pasien'];
		?>
		
		<p class="title-dark">Current</p>
		<div class="padding-20">
			<table class="table">
				<thead>
					<tr>
						<th width="60px">Tanggal</th>
						<th width="150px">Kunjungan</th>
						<th width="150px">Teks</th>
						<th width="80px">ATC Code</th>
						<th>Catatan</th>
						<th width="100px">#</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$tampil=pg_query($dbconn,"SELECT * FROM pasien_peringatan WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N' ORDER BY id DESC");
						while($r=pg_fetch_array($tampil)){
							$a=explode(" ",$r['waktu_input']);
							$tanggal_input=DateToIndo2($a[0]);
						
							$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_tbl_atccode WHERE id='$r[id_kode_atc]'"));
							$nama_kode=$a['code'];
							
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
									if($a['detail_segmen']!=''){
										$kunjungan="$a[keterangan]-$a[detail_segmen]";
									}
									else{
										$kunjungan="$a[keterangan]";
									}
								}
							}
							?>
							<tr>
								<td><?php echo $tanggal_input;?></td>
								<td><?php echo $kunjungan;?></td>
								<td><?php echo $r['judul'];?></td>
								<td><?php echo $nama_kode;?></td>
								<td><?php echo $r['catatan'];?></td>
								<td>
									<button type="button" class="btn btn-info btn-xs btnEditPeringatan" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
									<button type="button" class="btn btn-warning btn-xs btnStopPeringatan" id="<?php echo $r['id'];?>" ><i class="icon-ban"></i></button>
									<button type="button" class="btn btn-danger btn-xs btnHapusPeringatan" id="<?php echo $r['id'];?>" ><i class="icon-trash"></i></button>
								</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
		<br>
		<p class="title-dark">Discontinued</p>
		<div class="padding-20">
			<table class="table">
				<thead>
					<tr>
						<th width="60px">Tanggal</th>
						<th width="150px">Kunjungan</th>
						<th width="150px">Teks</th>
						<th width="80px">ATC Code</th>
						<th>Catatan</th>
						<th width="100px">#</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$tampil=pg_query($dbconn,"SELECT * FROM pasien_peringatan WHERE id_pasien='$id_pasien' AND status_aktif='N' AND status_hapus='N' ORDER BY id DESC");
						while($r=pg_fetch_array($tampil)){
							$a=explode(" ",$r['waktu_input']);
							$tanggal_input=DateToIndo2($a[0]);
							
							$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_tbl_atccode WHERE id='$r[id_kode_atc]'"));
							$nama_kode=$a['code'];
							
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
									if($a['detail_segmen']!=''){
										$kunjungan="$a[keterangan]-$a[detail_segmen]";
									}
									else{
										$kunjungan="$a[keterangan]";
									}
								}
							}
							?>
							<tr>
								<td><?php echo $tanggal_input;?></td>
								<td><?php echo $kunjungan;?></td>
								<td><?php echo $r['judul'];?></td>
								<td><?php echo $nama_kode;?></td>
								<td><?php echo $r['catatan'];?></td>
								<td>
									<button type="button" class="btn btn-danger btn-xs btnHapusPeringatan" id="<?php echo $r['id'];?>" ><i class="icon-trash"></i></button>
								</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
		
		<script type="text/javascript">
			$(function () {
				$("#id_kategori_peringatan").change(function(){
					var id_kategori_peringatan=$(this).val();
					if(id_kategori_peringatan==1){
						$('#id_kode_atc').prop('disabled', false);
					}
					else{
						$('#id_kode_atc').prop('disabled', true);
					}
				});
				
				$(".btnTambah").click(function(){
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					$.ajax({
						type: 'POST',
						url: 'form-tambah-pasien-peringatan',
						success: function(msg){
							$("#form-modal2").html(msg);
							$("#form-modal2").modal('show'); 
						}
					});
				});
				
				
				
				$(".btnEditPeringatan").click(function(){
					var id = this.id;
					$.ajax({
						type: 'POST',
						url: 'form-edit-pasien-peringatan',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#form-modal2").html(msg);
							$("#form-modal2").modal('show'); 
						}
					});
					
				});
				
				$(".btnStopPeringatan").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menonaktifkan peringatan ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-stop-pasien-peringatan',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_peringatan").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-peringatan',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_peringatan").html(msg);
								alert("Peringatan berhasil dinonaktifkan");
							}
						});
					}
					else{
						return false;
					}
				});
				
				$(".btnHapusPeringatan").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus peringatan ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var dataString2 = 'id_pasien='+id_pasien;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-peringatan',
							data: { 
								'id': id
							},
							success: function(msg){
								//$("#data_peringatan").html(msg);
							}
						});
						
						$.ajax({
							type: 'POST',
							url: 'data-pasien-peringatan',
							data: dataString2,
							cache: false,
							success: function(msg){
								$("#data_peringatan").html(msg);
								alert("Peringatan berhasil dihapus");
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
	
	elseif ($module=='peringatan' AND $act=='input'){
		
		pg_query($dbconn,"INSERT INTO pasien_peringatan (id_pasien, judul, id_kode_atc, catatan, version, waktu_input, status_aktif, status_hapus, id_user, id_unit, id_kunjungan) VALUES ('$_POST[id_pasien]', '$_POST[judul]', '$_POST[id_kode_atc]', '$_POST[catatan]', '1', '$tgl_sekarang $jam_sekarang', 'Y', 'N', '$_SESSION[login_user]', '$_SESSION[id_units]', '$_POST[id_kunjungan]')");
		
	}
	
	elseif ($module=='peringatan' AND $act=='inputform'){
		?>
		<div class="modal-dialog modal-sm modal-info">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="title-form">Tambah</h6>
				</div>
				<div class="modal-body" id="form-data">
				
					<div class="form-group">
						<label>Teks</label>
						<input type="text" name="judul" id="judul" class="form-control" required>
					</div>
					
					<div class="form-group">
						<label>ATC Code</label>
						<select class="js-example-basic-single form-control" name="id_kode_atc" id="id_kode_atc">
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM master_tbl_atccode ORDER BY id");
							while($r=pg_fetch_array($tampil)){
								echo"<option value='$r[id]'>$r[code] - $r[deskripsi]</option>";
							}
							?>
						</select>
					</div>
					
					<div class="form-group">
						<label>Catatan</label>
						<textarea name="catatan" id="catatan" class="form-control"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary btn-sm" id="btnSimpanPeringatan">Simpan</button>
				</div>
			</div>
		</div>
		<script>
		$("#id_kategori_peringatan").change(function(){
			var id_kategori_peringatan=$(this).val();
			if(id_kategori_peringatan==1){
				$('#id_kode_atc').prop('disabled', false);
			}
			else{
				$('#id_kode_atc').prop('disabled', true);
			}
		});
		
		$('#btnSimpanPeringatan').click(function()
		{
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var judul=$("#judul").val();
			var id_kode_atc=$("#id_kode_atc").val();
			var catatan=$("#catatan").val();
			var dataString = 'id_pasien='+id_pasien+'&judul='+judul+'&id_kode_atc='+id_kode_atc+'&catatan='+catatan+'&id_kunjungan='+id_kunjungan;
			var dataString2 = 'id_pasien='+id_pasien;
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pasien-peringatan",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnSimpanPeringatan").val('Submitting...');},
				success: function(data){
					$('#form-modal2').modal('toggle');
					//alert('simpan');
				}
			});
			$.ajax({
				type: "POST",
				url: "data-pasien-peringatan",
				data: dataString2,
				cache: false,
				success: function(data){
					$("#data_peringatan").html(data);
					alert('Data berhasil disimpan');
				}
			});

		});
		</script>
	<?php
	}
	
	
	elseif ($module=='peringatan' AND $act=='editform'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_peringatan WHERE id='$_POST[id]'"));
		?>
		<div class="modal-dialog modal-sm modal-info">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="title-form">Edit</h6>
				</div>
				<div class="modal-body" id="form-data">
					<input type="hidden" name="id" id="id" value="<?php echo $d['id'];?>">
					
					
					<div class="form-group">
						<label>Teks</label>
						<input type="text" name="judul" id="judul" class="form-control" required value="<?php echo $d['judul'];?>">
					</div>
					
					<div class="form-group">
						<label>ATC Code</label>
						<select class="js-example-basic-single form-control" name="id_kode_atc" id="id_kode_atc" 
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM master_tbl_atccode ORDER BY id");
							while($r=pg_fetch_array($tampil)){
								if($r['id']==$d['id_kode_atc']){
									echo"<option value='$r[id]' selected>$r[code] - $r[deskripsi]</option>";
								}
								else{
									echo"<option value='$r[id]'>$r[code] - $r[deskripsi]</option>";
								}
							}
							?>
						</select>
					</div>
					
					<div class="form-group">
						<label>Catatan</label>
						<textarea name="catatan" id="catatan" class="form-control"><?php echo $d['catatan'];?></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary btn-sm" id="btnSimpanEditPeringatan">Simpan</button>
				</div>
			</div>
		</div>
		
		<script>
		$("#id_kategori_peringatan").change(function(){
			var id_kategori_peringatan=$(this).val();
			if(id_kategori_peringatan==1){
				$('#id_kode_atc').prop('disabled', false);
			}
			else{
				$('#id_kode_atc').prop('disabled', true);
			}
		});
		
		$('#btnSimpanEditPeringatan').click(function()
		{
			var id=$("#id").val();
			var id_pasien=$("#id_pasien").val();
			var id_kategori_peringatan=$("#id_kategori_peringatan").val();
			var judul=$("#judul").val();
			var id_kode_atc=$("#id_kode_atc").val();
			var catatan=$("#catatan").val();
			var dataString = 'id='+id+'&id_kategori_peringatan='+id_kategori_peringatan+'&judul='+judul+'&id_kode_atc='+id_kode_atc+'&catatan='+catatan;
			var dataString2 = 'id_pasien='+id_pasien;
			$.ajax({
				type: "POST",
				url: "aksi-edit-pasien-peringatan",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnSimpanEditPeringatan").val('Submitting...');},
				success: function(data){
					$('#form-modal2').modal('toggle');
					//alert("simpan");
				}
			});
			$.ajax({
				type: "POST",
				url: "data-pasien-peringatan",
				data: dataString2,
				cache: false,
				success: function(data){
					$("#data_peringatan").html(data);
					alert('Data berhasil diperbaharui');
				}
			});
		});
		
		</script>
		<?php
	}
	
	elseif ($module=='peringatan' AND $act=='update'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_peringatan WHERE id='$_POST[id]'"));
		$version=$d['version']+1;
		
		pg_query($dbconn,"UPDATE pasien_peringatan SET judul='$_POST[judul]', id_kode_atc='$_POST[id_kode_atc]', catatan='$_POST[catatan]' WHERE id='$_POST[id]'");
	}
	
	elseif ($module=='peringatan' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_peringatan SET status_hapus='Y', status_aktif='N', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
	}
	
	elseif ($module=='peringatan' AND $act=='stop'){
		pg_query($dbconn,"UPDATE pasien_peringatan SET status_aktif='N' WHERE id='$_POST[id]'");
	}
	
	elseif($module=='peringatan' AND $act=='action_button'){
		$id_pasien=$_POST['id_pasien'];
		$d=pg_fetch_array(pg_query($dbconn,"SELECT no_rm FROM master_pasien WHERE id='$_POST[id_pasien]'"));
		
		$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_peringatan WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N'"));
		if($c['tot']>0){
		?>
		<button type="button" class="btn btn-warning btn-xs btnperingatanPasien" id="<?php echo $d['no_rm'];?>"><i class="fa fa-exclamation-circle"></i></button>
		<?php
		}
		$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_peringatan WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N'"));
		if($c['tot']>0){
		?>
		<button type="button" class="btn btn-danger btn-xs btnPeringatanPasien" id="<?php echo $d['no_rm'];?>"><i class="fa fa-exclamation-triangle"></i></button>
		
		<?php
		}
	}
	
	pg_close($dbconn);
}
?>