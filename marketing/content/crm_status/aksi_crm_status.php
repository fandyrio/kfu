<?php
session_start();
//error_reporting(0);
if (empty($_SESSION['login_user'])){
  header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];

	// Input user
	if ($module=='crm_status' AND $act=='input'){
		pg_query($dbconn,"INSERT INTO master_mt_crm_status (nama) VALUES ('$_POST[nama]')");
		header("location:crm-status");
	}

	elseif ($module=='crm_status' AND $act=='tambah'){
		?>
		<form method="POST" class="form-horizontal" action="aksi-tambah-crm-status" enctype="multipart/form-data">
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
							<label class="col-sm-3 control-label">Description</label>
							<div class="col-sm-8">
								<input type="text" name="nama" class="form-control" required autofocus>
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
	
	elseif ($module=='crm_status' AND $act=='edit'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_mt_crm_status WHERE id='$_POST[id]'"));
		?>
		<form method="POST" class="form-horizontal" action="aksi-edit-crm-status" enctype="multipart/form-data">
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
							<label class="col-sm-3 control-label">Description</label>
							<div class="col-sm-8">
								<input type="text" name="nama" class="form-control" required autofocus value="<?php echo $d['nama'];?>">
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
	
	elseif ($module=='crm_status' AND $act=='update'){
		pg_query($dbconn,"UPDATE master_mt_crm_status SET nama='$_POST[nama]' WHERE id='$_POST[id]'");
		header("location:crm-status");
	}

	elseif ($module=='crm_status' AND $act=='delete'){
		pg_query($dbconn,"DELETE FROM master_mt_crm_status WHERE id='$_GET[id]'");
		header("location:crm-status");
		
	}
}
?>
