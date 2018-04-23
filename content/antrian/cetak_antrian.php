<?php
session_start();
//error_reporting(0);
if (empty($_SESSION['login_user'])){
	header("location:keluar");
}
else{
	include "../../config/conn.php";
	include "../../config/library.php";
	include "../../config/fungsi_tanggal.php";
	
	$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
	$id_kategori_harga=$_GET['id_kategori_harga'];
	$id_segmen=$_GET['id_segmen'];
	$tanggal_awal=$_GET['tanggal_awal'];
	$tanggal_akhir=$_GET['tanggal_akhir'];
	
	$tanggal_awal2=DateToIndo2($tanggal_awal);
	$tanggal_akhir2=DateToIndo2($tanggal_akhir);
	echo"<html>
		<head>
			<style type='text/css'>
				@page { size:A4; margin: 1cm }
									  
				body{
					font-family:Times;
					font-size:11px;
				}
			
				div.box-header{
					text-align:center;
					padding-bottom:20px;
				}
				
				div.box-body{
					font-size:12px;
					clear:both;
					margin-top:30px;
				}
				
				span.title{
					margin:0;
					font-size:14px;
					font-weight:bold;
					display:block;
				}
				
				span.alamat{
					margin:0;
					font-size:12px;
					display:block;
				}
				
				span.telepon{
					font-size:12px;
					display:block;
				}
				
				.alignleft {
					float: left;
					width:33.33333%;
					text-align:left;
				}
				.aligncenter {
					float: left;
					width:33.33333%;
					text-align:center;
				}
				.alignright {
					float: left;
					width:33.33333%;
					text-align:right;
				}​
				
				
				table{
					font-size:11px;
				}
				
				table thead tr th, table tbody tr td{
					font-size:11px;
				}
			</style>
			
			<script>
			function myFunction() {
				setTimeout(function () { window.print(); }, 500);
				window.onfocus = function () { setTimeout(function () { window.close(); }, 200); }
			}
			</script>
		</head>
		<body onload='window.print()' onfocus='window.close()'>
			<div class='box-header'>
				<div class='alignleft'>
					<img src='images/$setting[logo]' width='60px'>
				</div>
				<div class='aligncenter'>
					<span class='title'>$setting[nama]</span>
					
					<span class='telepon'>Telp. $setting[telepon] Email. $setting[email]</span>
				</div>
				
				<div class='alignright'>
				
				</div>
			</div>
			<div class='box-body'>
				<hr>
					<center>DATA ANTRIAN<br>$tanggal_awal2 s/d $tanggal_akhir2</center>
				<br>
				<table style='width:100%;border-collapse:collapse;'>
					<thead>
						<tr>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:20px;'>No.</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Jam Masuk</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>No. Antrian</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Nama Pasien</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Dokter</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Penjamin</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Detail Segmen</th>
						</tr>
					</thead>
					<tbody>";
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

						$no=1;
						while($r=pg_fetch_array($tampil)){
							$k=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_dokter]'"));
							$p=pg_fetch_array(pg_query($dbconn,"SELECT nama, no_rm, id FROM master_pasien WHERE id='$r[id_pasien]'"));
							
							$a=explode(" ",$r['waktu_masuk']);
							$tanggal_masuk=DateToIndo2($a[0]);
							
							
							$kh=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$r[id_kategori_harga]'"));
							$nama_kategori_harga=$kh['nama'];
							
							
							$s=pg_fetch_array(pg_query($dbconn,"SELECT * FROM segmen WHERE id='$r[id_segmen]'"));
							echo"
							<tr>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'>$no</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'>$tanggal_masuk $a[1]</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'>$r[no_antrian]</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'>$p[nama]/$p[no_rm]</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'>$k[nama]</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'>$nama_kategori_harga</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'>$s[nama]</td>
							</tr>
							";
							$no++;
						}	
					echo"
					</tbody>
				</table>
			</div>
		</body>
	</html>";

}
?>
