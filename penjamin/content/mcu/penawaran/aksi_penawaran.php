<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
  header('location:keluar');
}
else{
	include "../../../../config/conn.php";
	include "../../../../config/library.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];

	// Input user
	if ($module=='penawaran' AND $act=='aksisimpan'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM billing_paket WHERE id='$_POST[id]'"));
		pg_query($dbconn,"INSERT INTO billing_paket_penawaran_log (id_billing_paket, id_status_penawaran, waktu_input, catatan, id_users, id_perusahaan, created_by) VALUES ('$_POST[id]', '$_POST[status]', '$tgl_sekarang $jam_sekarang', '$_POST[catatan]', '$d[id_users]', '$_SESSION[login_user]', 'P')");
		
		pg_query($dbconn,"UPDATE billing_paket SET status='$_POST[status]' WHERE id='$_POST[id]'");
		
		header("location:view-mcu-penawaran-$_POST[id]");
	}

	elseif ($module=='penawaran' AND $act=='revisi'){
		?>
		<form method="POST" class="form-horizontal" action="aksi-mcu-penawaran" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $_POST['id'];?>">
			<input type="hidden" name="status" value="8">
			<div class="modal-dialog modal-warning" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Permintaan Revisi</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Keterangan/Catatan</label>
							<div class="col-sm-8">
								<textarea name="catatan" class="form-control"></textarea>
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
	
	elseif ($module=='penawaran' AND $act=='tolak'){
		?>
		<form method="POST" class="form-horizontal" action="aksi-mcu-penawaran" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $_POST['id'];?>">
			<input type="hidden" name="status" value="5">
			<div class="modal-dialog modal-danger" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tolak Penawaran</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Keterangan/Catatan</label>
							<div class="col-sm-8">
								<textarea name="catatan" class="form-control"></textarea>
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

	elseif ($module=='penawaran' AND $act=='terima'){
		?>
		<form method="POST" class="form-horizontal" action="aksi-mcu-penawaran" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $_POST['id'];?>">
			<input type="hidden" name="status" value="4">
			<div class="modal-dialog modal-success" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Terima Penawaran</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Keterangan/Catatan</label>
							<div class="col-sm-8">
								<textarea name="catatan" class="form-control"></textarea>
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
}
?>
