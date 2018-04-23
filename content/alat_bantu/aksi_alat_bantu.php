<?php
session_start();
//error_reporting(0);
if (empty($_SESSION['login_user'])){
  header('location:keluar');
}
else{
	include "../../config/conn.php";
	include "../../config/library.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];

	// Input user
	if ($module=='alat_bantu' AND $act=='input'){
		pg_query($dbconn,"INSERT INTO inv_alat_bantu_unit (id_inv_alat_bantu, jumlah, otomatis, id_unit) VALUES ('$_POST[id_inv_alat_bantu]', '$_POST[jumlah]', '$_POST[otomatis]', '$_SESSION[id_units]')");
		header("location:alat-bantu");
	}

	elseif ($module=='alat_bantu' AND $act=='tambah'){
		?>
		<form method="POST" class="form-horizontal" action="aksi-tambah-alat-bantu" enctype="multipart/form-data">
			<div class="modal-dialog modal-primary" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tambah</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Alat Bantu</label>
							<div class="col-sm-8">
								<select name="id_inv_alat_bantu" class="form-control">
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM inv_alat_bantu");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-3 control-label">Jumlah</label>
							<div class="col-sm-8">
								<input type="number" name="jumlah" class="form-control" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Otomatis</label>
							<div class="col-sm-8">
								<select name="otomatis" class="form-control">
									<option value="Y">Ya</option>
									<option value="N">Tidak</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success btn-flat btn-sm">SIMPAN</button>
						<button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal">BATAL</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</form>
		<?php
	}
	
	elseif ($module=='alat_bantu' AND $act=='edit'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM inv_alat_bantu_unit WHERE id='$_POST[id]'"));
		?>
		<form method="POST" class="form-horizontal" action="aksi-edit-alat-bantu" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>">
			<div class="modal-dialog modal-primary" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Edit</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Alat Bantu</label>
							<div class="col-sm-8">
								<select name="id_inv_alat_bantu" class="form-control">
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM inv_alat_bantu");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_inv_alat_bantu']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-3 control-label">Jumlah</label>
							<div class="col-sm-8">
								<input type="number" name="jumlah" class="form-control" required value="<?php echo $d['jumlah'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Otomatis</label>
							<div class="col-sm-8">
								<select name="otomatis" class="form-control">
									<option value="Y" <?php if($d['otomatis']=='Y'){ echo "selected";}?>>Ya</option>
									<option value="N" <?php if($d['otomatis']=='N'){ echo "selected";}?>>Tidak</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success btn-flat btn-sm">SIMPAN</button>
						<button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal">BATAL</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</form>
		<?php
	}
	
	elseif ($module=='alat_bantu' AND $act=='update'){
		pg_query($dbconn,"UPDATE inv_alat_bantu_unit SET id_inv_alat_bantu='$_POST[id_inv_alat_bantu]', jumlah='$_POST[jumlah]', otomatis='$_POST[otomatis]', id_unit='$_SESSION[id_units]' WHERE id='$_POST[id]'");
		header("location:alat-bantu");
	}

	elseif ($module=='alat_bantu' AND $act=='delete'){
		pg_query($dbconn,"DELETE FROM inv_alat_bantu_unit WHERE id='$_GET[id]'");
		header("location:alat-bantu");
		
	}
}
?>
