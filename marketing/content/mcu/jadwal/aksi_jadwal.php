<?php
session_start();
//error_reporting(0);
if (empty($_SESSION['login_user'])){
  header('location:keluar');
}
else{
	include "../../../../config/conn.php";
	include "../../../../config/library.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];

	// Input user
	if ($module=='mcu_jadwal' AND $act=='aksiselesai'){
		pg_query($dbconn,"UPDATE billing_paket SET status='$_POST[status]', keterangan='$_POST[keterangan]' WHERE id='$_POST[id]'");
		header("location:mcu-jadwal");
	}

	elseif ($module=='mcu_jadwal' AND $act=='selesai'){
		?>
		<form method="POST" class="form-horizontal" action="aksi-selesai-mcu-jadwal" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $_POST['id'];?>">
			<input type="hidden" name="status" value="6">
			<div class="modal-dialog modal-warning" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Expired Jadwal</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Keterangan/Catatan</label>
							<div class="col-sm-8">
								<textarea name="keterangan" class="form-control"></textarea>
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
