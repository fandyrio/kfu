<html>
<head>
<link href="assets/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
<?php
error_reporting(0);
include "../../config/conn.php";
include "../../config/fungsi_tanggal.php";

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
?>
<div class="card">
	<div class="card-header">
		<strong>Riwayat Kunjungan Rawat Jalan</strong>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-12">
				<?php
				$tampil=pg_query($dbconn,"SELECT a.id, a.waktu_input, a.id_kategori_harga FROM kunjungan a, antrian b WHERE a.id=b.id_kunjungan AND a.id_pasien='$d[id]' ORDER BY a.id DESC");
				
				while($r=pg_fetch_array($tampil)){
					$a=explode(" ",$r['waktu_input']);
					$tanggal=DateToIndo($a[0]);
					
					$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$r[id_kategori_harga]'"));
					$nama_kategori_harga=$a['nama'];
				?>
				<div class="padding-20">
					<table class="table" id="myTable3">
						<thead>
							<tr>
								<th width="50px"></th>
								<th width="130px">Waktu Masuk</th>
								<th>No. Antrian</th>
								<th>Dokter</th>
								<th>Penjamin</th>
								<th>Detail Segmen</th>
							</tr>
						</thead>
						<?php
						$antrian=pg_query($dbconn,"SELECT * FROM antrian WHERE id_kunjungan='$r[id]' ORDER BY id DESC");
						while($a=pg_fetch_array($antrian)){
							
							$j=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_karyawan WHERE id='$a[id_dokter]'"));
							$nama_dokter=$j['nama'];
							
							$j=explode(" ",$a['waktu_masuk']);
							$tanggal_masuk=DateToIndo2($j[0]);
							$jam_masuk=$j[1];
							
							
							$pr=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_prioritas_pasien WHERE id='$a[id_prioritas]'"));
							
							$prioritas="<button class='btn btn-$pr[warna] btn-xs' title='$pr[nama]'><i class=' fa fa-square'></i></button>";
							
							$s=pg_fetch_array(pg_query($dbconn,"SELECT * FROM segmen WHERE id='$a[id_segmen]'"));
							$nama_segmen="<button class='btn btn-$s[warna] btn-xs' title='$s[nama]'><i class='icon-user'></i></button>";

							$kh=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$a[id_kategori_harga]'"));
							$nama_kategori_harga=$kh['nama'];
							?>
							
							<tr>
								<td><?php echo "$prioritas $nama_segmen";?></td>
								<td><a href="#" id="<?php echo $a['id'];?>" class="btnViewKunjungan"><?php echo "$tanggal_masuk $jam_masuk";?></a></td>
								<td><?php echo $a['no_antrian'];?></td>
								<td><?php echo $nama_dokter;?></td>
								<td><?php echo $nama_kategori_harga;?></td>
								<td><?php echo $a['detail_segmen'];?></td>
							</tr>
							<?php
						}
						?>
					</table>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
							
<?php
	pg_close($dbconn);
?>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/datatable_code_ajax.js"></script>
</body>
</html>