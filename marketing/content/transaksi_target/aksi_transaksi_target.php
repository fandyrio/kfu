<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
  header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];

	// Input user
	if ($module=='transaksi_target' AND $act=='input'){
		pg_query($dbconn,"INSERT INTO mt_transaksi_target (id_unit, id_segmen, description, tahun, bln1, bln2, bln3, bln4, bln5, bln6, bln7, bln8, bln9, bln10, bln11, bln12) VALUES ('$_POST[id_unit]', '$_POST[id_segmen]', '$_POST[description]', '$_POST[tahun]', '$_POST[bln1]', '$_POST[bln2]', '$_POST[bln3]', '$_POST[bln4]', '$_POST[bln5]', '$_POST[bln6]', '$_POST[bln7]', '$_POST[bln8]', '$_POST[bln9]', '$_POST[bln10]', '$_POST[bln11]', '$_POST[bln12]')");
		
		header("location:transaksi-target");
	}

	elseif ($module=='transaksi_target' AND $act=='tambah'){
		?>
		<form method="POST" class="form-horizontal" action="aksi-tambah-transaksi-target" enctype="multipart/form-data">
			<div class="modal-dialog modal-primary modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tambah</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-sm-2 control-label">Unit</label>
							<div class="col-sm-4">
								<select name="id_unit" class="form-control" required>
									<option value="">Pilih</option>
									<?php
									$tampil=pg_query($dbconn,"SELECT id, nama FROM master_unit ORDER BY nama");
									while($r=pg_fetch_array($tampil)){
										?>
										<option value="<?php echo $r['id'];?>"><?php echo $r['nama'];?></option>
										<?php
									}
									?>
								</select>
							</div>
							
							<label class="col-sm-2 control-label">Segmen</label>
							<div class="col-sm-4">
								<select name="id_segmen" class="form-control" required>
									<option value="">Pilih</option>
									<?php
									$tampil=pg_query($dbconn,"SELECT id, nama FROM segmen");
									while($r=pg_fetch_array($tampil)){
										?>
										<option value="<?php echo $r['id'];?>"><?php echo $r['nama'];?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-4">
								<textarea name="description" class="form-control"></textarea>
							</div>
							<label class="col-sm-2 control-label">Tahun</label>
							<div class="col-sm-4">
								<input type="number" name="tahun" class="form-control">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">Januari</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln1">
							</div>
							<label class="col-sm-2 control-label">Februari</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln2">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">Maret</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln3">
							</div>
							<label class="col-sm-2 control-label">April</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln4">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">Mei</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln5">
							</div>
							<label class="col-sm-2 control-label">Juni</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln6">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">Juli</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln7">
							</div>
							<label class="col-sm-2 control-label">Agustus</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln8">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">September</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln9">
							</div>
							<label class="col-sm-2 control-label">Oktober</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln10">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">November</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln11">
							</div>
							<label class="col-sm-2 control-label">Desember</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln12">
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
	
	elseif ($module=='transaksi_target' AND $act=='edit'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM mt_transaksi_target WHERE id='$_POST[id]'"));
		?>
		<form method="POST" class="form-horizontal" action="aksi-edit-transaksi-target" enctype="multipart/form-data">
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
							<label class="col-sm-2 control-label">Unit</label>
							<div class="col-sm-4">
								<select name="id_unit" class="form-control" required>
									<option value="">Pilih</option>
									<?php
									$tampil=pg_query($dbconn,"SELECT id, nama FROM master_unit ORDER BY nama");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_unit']){
											?>
											<option value="<?php echo $r['id'];?>" selected><?php echo $r['nama'];?></option>
											<?php
										}
										else{
											?>
											<option value="<?php echo $r['id'];?>"><?php echo $r['nama'];?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
							
							<label class="col-sm-2 control-label">Segmen</label>
							<div class="col-sm-4">
								<select name="id_segmen" class="form-control" required>
									<option value="">Pilih</option>
									<?php
									$tampil=pg_query($dbconn,"SELECT id, nama FROM segmen");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_segmen']){
											?>
											<option value="<?php echo $r['id'];?>" selected><?php echo $r['nama'];?></option>
											<?php
										}
										else{
											?>
											<option value="<?php echo $r['id'];?>"><?php echo $r['nama'];?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-4">
								<textarea name="description" class="form-control"><?php echo $d['description'];?></textarea>
							</div>
							<label class="col-sm-2 control-label">Tahun</label>
							<div class="col-sm-4">
								<input type="number" name="tahun" class="form-control" value="<?php echo $d['tahun'];?>">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">Januari</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln1" value="<?php echo $d['bln1'];?>">
							</div>
							<label class="col-sm-2 control-label">Februari</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln2" value="<?php echo $d['bln2'];?>">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">Maret</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln3" value="<?php echo $d['bln3'];?>">
							</div>
							<label class="col-sm-2 control-label">April</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln4" value="<?php echo $d['bln4'];?>">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">Mei</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln5" value="<?php echo $d['bln5'];?>">
							</div>
							<label class="col-sm-2 control-label">Juni</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln6" value="<?php echo $d['bln6'];?>">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">Juli</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln7" value="<?php echo $d['bln7'];?>">
							</div>
							<label class="col-sm-2 control-label">Agustus</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln8" value="<?php echo $d['bln8'];?>">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">September</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln9" value="<?php echo $d['bln9'];?>">
							</div>
							<label class="col-sm-2 control-label">Oktober</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln10" value="<?php echo $d['bln10'];?>">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2 control-label">November</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln11" value="<?php echo $d['bln11'];?>">
							</div>
							<label class="col-sm-2 control-label">Desember</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="bln12" value="<?php echo $d['bln12'];?>">
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
	
	elseif ($module=='transaksi_target' AND $act=='update'){
		pg_query($dbconn,"UPDATE mt_transaksi_target SET id_unit='$_POST[id_unit]', id_segmen='$_POST[id_segmen]', description='$_POST[description]', tahun='$_POST[tahun]', bln1='$_POST[bln1]', bln2='$_POST[bln2]', bln3='$_POST[bln3]', bln4='$_POST[bln4]', bln5='$_POST[bln5]', bln6='$_POST[bln6]', bln7='$_POST[bln7]', bln8='$_POST[bln8]', bln9='$_POST[bln9]', bln10='$_POST[bln10]', bln11='$_POST[bln11]', bln12='$_POST[bln12] WHERE id='$_POST[id]'");
		header("location:transaksi-target");
	}

	elseif ($module=='transaksi_target' AND $act=='delete'){
		pg_query($dbconn,"DELETE FROM master_mt_transaksi_target WHERE id='$_GET[id]'");
		header("location:transaksi-target");
		
	}
}
?>
