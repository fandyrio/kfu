<?php
session_start();
include "../../config/conn.php";
include "../../config/library.php";
include "../../config/fungsi_tanggal.php";

$id_kategori_harga=$_GET['id_kategori_harga'];
$id_segmen=$_GET['id_segmen'];
$tanggal_awal=$_GET['tanggal_awal'];
$tanggal_akhir=$_GET['tanggal_akhir'];
?>

<table class="table" id="myTable">
	<thead>
		<tr>
		<th width="50px"></th>
		<th width="160px">Jam Masuk</th>
		<th>No. Antrian</th>
		<th>Nama Pasien / No. RM</th>
		<th>Nama Dokter</th>
		<th>Penjamin</th>
		<th width="120px">#</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($id_kategori_harga==0){
			if($id_segmen==0){
				$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND  waktu_masuk BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir 23:59:59' ORDER BY id_prioritas DESC");
			}
			else{
				$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND  id_segmen='$id_segmen' AND waktu_masuk BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir 23:59:59' ORDER BY id_prioritas DESC");
			}
		}
		else{
			if($id_segmen==0){
				$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND id_kategori_harga='$id_kategori_harga' AND waktu_masuk BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir 23:59:59' ORDER BY id_prioritas DESC");
			}
			else{
				$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND id_kategori_harga='$id_kategori_harga' AND id_segmen='$id_segmen' AND  waktu_masuk BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir 23:59:59' ORDER BY id_prioritas DESC");
			}
		}
		//$no=1;
		while($r=pg_fetch_array($tampil)){

				if($r['id_dokter']!="")
				{
					$k=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_dokter]'"));
					$namaDokter=$k['nama'];
				}
				else
				{
					$namaDokter="-";
				}

			$p=pg_fetch_array(pg_query($dbconn,"SELECT nama, no_rm, id FROM master_pasien WHERE id='$r[id_pasien]'"));
			
			$a=explode(" ",$r['waktu_masuk']);
			$tanggal_masuk=DateToIndo2($a[0]);
			
			
			$kh=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$r[id_kategori_harga]'"));
			$nama_kategori_harga=$kh['nama'];
			
			$pr=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_prioritas_pasien WHERE id='$r[id_prioritas]'"));
			
			$prioritas="<button class='btn btn-$pr[warna] btn-xs' title='$pr[nama]'><i class=' fa fa-square'></i></button>";
			/*
			$s=pg_fetch_array(pg_query($dbconn,"SELECT * FROM segmen WHERE id='$r[id_segmen]'"));
								$nama_segmen="<button class='btn btn-$s[warna] btn-xs' title='$s[nama]'><i class='icon-user'></i></button>";*/
			?>
			<tr>
				<td><?php echo "$prioritas";?></td>
				<td><?php echo "$tanggal_masuk $a[1]";?></td>
				<td><?php echo $r['no_antrian'];?></td>
				<td><a href="pasien-detail-<?php echo $p['no_rm'];?>"><?php echo "$p[nama] / $p[no_rm]";?></a></td>
				<td><?php echo $namaDokter;?></td>
				<td><?php echo $nama_kategori_harga;?></td>
				
				<td>
					
					<!--<button type="button" rel="tooltip" class="btnLamaAntri btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Lama Antrian" id="<?php echo $r['id'];?>">
						<i class="icon-magnifier"></i>
					</button>-->
					
					<!-- <a href="edit-antrian-<?php echo "$r[id]";?>" class="btn btn-primary btn-xs" title="Edit Antrian" data-toggle="tooltip" data-placement="top" title="Edit Antrian"><i class="icon-note"></i></a> -->
					
					<a href="hapus-antrian-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
					
					<a href="keuangan-customer-billing-<?php echo "$p[no_rm]";?>" class="btn btn-success btn-xs"  title="Billing" data-toggle="tooltip" data-placement="top"><i class="icon-calculator"></i></a>
					
					<!-- <a href="cetak-kartu-pasien-<?php echo "$p[no_rm]";?>" class="btn btn-secondary btn-xs" title="Cetak Kartu Pasien" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a> -->
					
					<!--<a href="cetak-gelang-pasien-<?php echo "$p[no_rm]";?>" class="btn btn-warning btn-xs" title="Cetak Gelang Pasien" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a>-->
					
					<a href="cetak-nomor-antrian?id=<?php echo $r['no_cetak_antrian'] ?>" class="btn btn-info btn-xs" title="Cetak no pasien" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a>
					<!-- <a href="form-<?php echo "$p[no_rm]";?>" class="btn btn-secondary btn-xs" title="Form Pemeriksaan" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-file-text "></i></a> -->
				</td>
			</tr>
			<?php
			//$no++;
		}
		?>
	</tbody>
</table>
<script src="assets/js/datatable_code.js"></script>