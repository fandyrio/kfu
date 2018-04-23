<?php
session_start();
//error_reporting(0);
if (empty($_SESSION['login_user'])){
  header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];

	// Input user
	if ($module=='laporan' AND $act=='input'){
		$tanggal=DateToEng($_POST['tanggal']);
		pg_query($dbconn,"INSERT INTO mt_laporan (waktu_input, tanggal, id_user, jumlah1, jumlah2, jumlah3, respon) VALUES ('$tgl_sekarang $jam_sekarang', '$tanggal', '$_SESSION[login_user]', '$_POST[jumlah1]', '$_POST[jumlah2]', '$_POST[jumlah3]', '$_POST[respon]')");
		header("location:laporan");
	}

	elseif ($module=='laporan' AND $act=='tambah'){
		?>
		<form method="POST" class="form-horizontal" action="aksi-tambah-laporan" enctype="multipart/form-data">
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
							<label class="col-sm-12 control-label">Tanggal</label>
							<div class="col-sm-12">
								<input id="datepicker" type="text" name="tanggal" class="form-control" required autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 control-label">Jumlah Dokter Yang Dikunjungi</label>
							<div class="col-sm-12">
								<input type="number" name="jumlah1" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 control-label">Jumlah Instansi Yang Dikunjungi</label>
							<div class="col-sm-12">
								<input type="number" name="jumlah2" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 control-label">Jumlah Pasien Yang Dikirim Dokter</label>
							<div class="col-sm-12">
								<input type="number" name="jumlah3" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 control-label">Respon Segmen</label>
							<div class="col-sm-12">
								<textarea name="respon" class="form-control"></textarea>
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
		
		<script type="text/javascript">
			$(function() {
				$( "#datepicker" ).datepicker({ format: 'dd-mm-yyyy' });
			});
        </script>
		<?php
	}
	
	elseif ($module=='laporan' AND $act=='edit'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM mt_laporan WHERE id='$_POST[id]'"));
		$tanggal=DateToIndo5($d['tanggal']);
		?>
		<form method="POST" class="form-horizontal" action="aksi-edit-laporan" enctype="multipart/form-data">
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
							<label class="col-sm-12 control-label">Tanggal</label>
							<div class="col-sm-12">
								<input id="datepicker" type="text" name="tanggal" class="form-control" required autofocus value="<?php echo $tanggal;?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 control-label">Jumlah Dokter Yang Dikunjungi</label>
							<div class="col-sm-12">
								<input type="number" name="jumlah1" class="form-control" value="<?php echo $d['jumlah1'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 control-label">Jumlah Instansi Yang Dikunjungi</label>
							<div class="col-sm-12">
								<input type="number" name="jumlah2" class="form-control" value="<?php echo $d['jumlah2'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 control-label">Jumlah Pasien Yang Dikirim Dokter</label>
							<div class="col-sm-12">
								<input type="number" name="jumlah3" class="form-control" value="<?php echo $d['jumlah3'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 control-label">Respon Segmen</label>
							<div class="col-sm-12">
								<textarea name="respon" class="form-control"><?php echo $d['respon'];?></textarea>
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
		<script type="text/javascript">
			$(function() {
				$( "#datepicker" ).datepicker({ format: 'dd-mm-yyyy' });
			});
        </script>
		<?php
	}
	
	elseif ($module=='laporan' AND $act=='update'){
		$tanggal=DateToEng($_POST['tanggal']);
		pg_query($dbconn,"UPDATE mt_laporan SET tanggal='$tanggal', jumlah1='$_POST[jumlah1]', jumlah2='$_POST[jumlah2]', jumlah3='$_POST[jumlah3]', respon='$_POST[respon]', waktu_input='$tgl_sekarang $jam_sekarang' WHERE id='$_POST[id]'");
		header("location:laporan");
	}

	elseif ($module=='laporan' AND $act=='delete'){
		pg_query($dbconn,"DELETE FROM mt_laporan WHERE id='$_GET[id]'");
		header("location:laporan");
		
	}
}
?>
