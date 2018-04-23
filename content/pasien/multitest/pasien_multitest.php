<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_POST[id]'"));
if($d['jenkel']==1){
	$jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-symbol-female'></i>";
}

if($d['foto']!=''){
	$foto="images/pasien/upload_$d[foto]";
}
else{
	$foto="images/default.png";
}

$id_pasien=$d['id'];

$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
$id_kunjungan=$a['id_kunjungan'];

?>
<input type="hidden" name="id" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<div class="card">
	<div class="card-header">
		<strong>Orderan Multi Test</strong>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-12" id="data_peringatan">
				<p class="title-dark">Data</p>
				<table class="table">
					<thead>
						<tr>
							<th width="100px">Tanggal</th>
							<th width="200px">Kunjungan</th>
							<th>Nama Multi Test</th>
							<th>Harga</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_aktif='Y' AND status_hapus='N' AND jenis='M' ORDER BY id DESC");
							while($r=pg_fetch_array($tampil)){
								$a=explode(" ",$r['waktu_input']);
								$tanggal_input=DateToIndo2($a[0]);
								
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
										$kunjungan="$a[keterangan]";
									}
								}
								
								
								$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_analysis_group WHERE id='$r[id_detail]'"));
								$nama_lab=$a['nama'];
								
								?>
								<tr>
									<td><?php echo $tanggal_input;?></td>
									<td><?php echo $kunjungan;?></td>
									<td><?php echo $nama_lab;?></td>
									<td><?php echo number_format($r['harga'],'0','','.');?> </td>
								</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
	pg_close($dbconn);
?>