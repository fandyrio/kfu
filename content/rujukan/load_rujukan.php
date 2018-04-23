<?php
 include "../../config/conn.php";
 switch ($_GET['act']) 
 {
 	case "view":
 	$id = $_POST["id"];
 	$row = pg_fetch_array(pg_query($dbconn, "SELECT * FROM pasien_rujukan Where id='$id'"));

 	
	?>
	<div class="modal-dialog modal-sm modal-info">
				<div class="modal-content">
				<form id="edit_status">
					<div class="modal-header">
						<h6 class="modal-title" id="title-form">Aprroval</h6>
					</div>
					<div class="modal-body" id="form-data">
						<input type="hidden" name="id" value="<?php echo $id?>">
						<div class="form-group">
							<label>Status</label>
							<select name="status" class="form-control" autofocus required>
							<?php if($row[status_diterima]==1){
									echo "<option value='1' selected>Belum Proses</option>
										  <option value='2'>Diterima</option>
										  <option value='3'>Ditolak</option>";

								}
								if($row[status_diterima]==2){
									echo "<option value='1' >Belum Proses</option>
										  <option value='2' selected>Diterima</option>
										  <option value='3'>Ditolak</option>";

								}
								if($row[status_diterima]==3){
									echo "<option value='1'>Belum Proses</option>
										  <option value='2'>Diterima</option>
										  <option value='3' selected>Ditolak</option>";

								} ?>
								
						</select>
					</div>
									
					<div class="form-group">
						<label>Catatan</label>
						<textarea name="catatan" class="form-control"><?php echo $row['catatan'];?></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary btn-sm" id="btnEditRujukan">Simpan</button>
				</div>
				</form>
			</div>
		</div>


 		<?php
 		break;
 	
 	case 'edit':
 		$id = $_POST["id"];
 		$status = $_POST["status"];
 		$catatan = $_POST["catatan"];
 		pg_query($dbconn, "update pasien_rujukan set status_diterima='$status', catatan='$catatan' Where id='$id'");
 		break;
 }
 
?>

<script>
	$("#btnEditRujukan").click(function(){
			var data=$("#edit_status").serialize();
				$.ajax({
						type: 'POST',
						url: 'content/rujukan/load_rujukan.php?act=edit',
						data : data,
						success: function(msg){		
						window.location='rujukan-diterima'					
						}
					});
				});				
</script>