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
	
	if ($module=='keuangan_customer_invoice' AND $act=='edit'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan, id, no_invoice, id_kategori_harga_bayar FROM transaksi_invoice WHERE id='$_POST[id]'"));
		//$k=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM kunjungan WHERE id='$d[id_kunjungan]'"));
		?>
		<form action="aksi-edit-keuangan-customer-invoice" method="POST" class="form-horizontal" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['id'];?>">
			<input type="hidden" name="no_invoice" value="<?php echo $d['no_invoice'];?>">
			<div class="modal-dialog modal-primary">
				<div class="modal-content">
					<div class="modal-header">
						<b>Switch Payment</b>
					</div>
					<div class="modal-body" id="form-data">
						<div class="form-group row">
							<label class="col-md-2">Pembayaran</label>
							<div class="col-md-8">
								<select name="id_kategori_harga_bayar" class="form-control">
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_harga");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_kategori_harga_bayar']){
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
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary btn-sm" id="btnSimpan">Simpan</button>
					</div>
				</div>
			</div>
		</form>
		<?php
	}
	
	elseif ($module=='keuangan_customer_invoice' AND $act=='update'){
		pg_query($dbconn,"UPDATE transaksi_invoice SET id_kategori_harga_bayar='$_POST[id_kategori_harga_bayar]' WHERE id='$_POST[id]'");
		
		header("location:view-keuangan-customer-invoice-$_POST[no_invoice]");
	}
	
	pg_close($dbconn);
}
?>