<?php
 include "../../../config/conn.php";
 include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";
 error_reporting(0);
 session_start();
 switch ($_GET['act']) 
 {
 	case "add":
 	$no_rm = $_POST["no_rm"];
 	$id_pasien = $_POST["id_pasien"];
 	$id_kunjungan = $_POST["id_kunjungan"];
 	$row = pg_fetch_array(pg_query($dbconn, "SELECT * FROM anamnesa_kesimpulan"));
 	
	?>
	<div class="modal-dialog modal-md modal-default">
				<div class="modal-content">
				<form id="form_add_sampel">
					<div class="modal-header">
						<h6 class="modal-title" id="title-form">Tambah Data Pengambilan Sampel</h6>
					</div>
					<div class="modal-body" id="form-data">
						<input type="hidden" name="id_pasien" value="<?php echo $id_pasien?>">
						<input type="hidden" id="no_rm" name="no_rm" value="<?php echo $no_rm?>">
						<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan?>">
						<div class="form-group">
							<label>Sampel</label>
							<select id="id_specimen" name="id_specimen" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM lab_specimen ORDER BY id");
									echo "<option>Pilih</option>";
									while($r=pg_fetch_array($tampil)){

										echo"<option value='$r[id]'>$r[nama]</option>";
									
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
					<button type="button" class="btn btn-primary btn-sm" id="btnSimpanSampel">Simpan</button>
				</div>
				</form>
			</div>
		</div>


 		<?php
 		break;

 		case 'update':
 		$row = pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_kesimpulan where id ='$_POST[id]'"));
 	
	?>
	<div class="modal-dialog modal-lg modal-info">
				<div class="modal-content">
				<form id="tbh_update">
					<div class="modal-header">
						<h6 class="modal-title" id="title-form">Kesimpulan dan Saran</h6>
					</div>
					<div class="modal-body" id="form-data">
					<input type="hidden" name="id" value="<?php echo $_POST[id]?>">
						<input type="hidden" id="no_rm" name="no_rm" value="<?php echo $_POST[no_rm]?>">
						<div class="form-group">
							<label>Status</label>
							<select id="id_specimen" id="id_specimen" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM anamnesa_kesimpulan ORDER BY id");
									echo "<option>Pilih</option>";
									while($r=pg_fetch_array($tampil)){

										echo"<option value='$r[id]' ket='$r[keterangan]' penj='$r[penjelasan]'>$r[keterangan]</option>";
									
									}
									?>
								</select>
						</select>
					</div>
									
					
					<div class="form-group">
						<label>Catatan</label>
						<textarea name="catatan" id="penjelasan" class="form-control"><?php echo $row[saran] ?></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary btn-sm" id="btnSaveEditRujukan">Simpan</button>
				</div>
				</form>
			</div>
		</div>


 		<?php
 		break;
 	
 		case 'edit':
 		
 		$id = $_POST["id"];
 		pg_query($dbconn, "update pasien_kesimpulan set kesimpulan='$_POST[kesimpulan]', saran='$_POST[saran]' Where id='$id'");
 		break;

 		case 'baru':
 		$id_pasien = $_POST["id_pasien"];
 		$id_kunjungan = $_POST["id_kunjungan"];
 		$id_specimen = $_POST["id_specimen"];
 		$catatan = $_POST["catatan"];
 		pg_query($dbconn, "INSERT INTO pasien_sampel (id_pasien, id_kunjungan, id_specimen,  waktu_input, id_unit, id_users, catatan) values ('$id_pasien', '$id_kunjungan', '$id_specimen', '$tgl_sekarang $jam_sekarang', '$_SESSION[id_units]', '$_SESSION[login_user]', '$catatan') ");
 		var_dump("INSERT INTO pasien_sampel (id_pasien, id_kunjungan, id_specimen,  waktu_input, id_unit, id_users, catatan) values ('$id_pasien', '$id_kunjungan', '$id_specimen', '$tgl_sekarang $jam_sekarang', '$_SESSION[id_units]', '$_SESSION[login_user]', '$catatan') ");

 		break;

 		case 'hapus':

 		pg_query($dbconn, "DELETE FROM pasien_sampel where id='$_POST[id]'");
 		
 			
 		break;
 }
 
?>

<script>
	$("#btnSimpanSampel").click(function(){
			var data=$("#form_add_sampel").serialize();
			var id=$("#no_rm").val();		
				$.ajax({
						type: 'POST',
						url: 'content/pasien/sampel/aksi.php?act=baru',
						data : data,
						success: function(msg){	
						//alert(msg);	
						$("#form-modal2").modal('hide'); 			
						$("#data_pasien").load('content/pasien/sampel/data.php?id='+id);				
						}
					});
				});

	$("#btnSaveEditRujukan").click(function(){
			var data=$("#tbh_update").serialize();
			var id=$("#no_rm").val();		
				$.ajax({
						type: 'POST',
						url: 'content/pasien/kesimpulan_saran/aksi.php?act=edit',
						data : data,
						success: function(msg){
						alert("berhasil diubah");
						$("#form-modal2").modal('hide'); 		
						$("#data_labhasil").load('content/pasien/kesimpulan_saran/kesimpulan.php?id='+id);				
						}
					});
				});

								
</script>