<?php
session_start();
error_reporting(1);
if (empty($_SESSION['login_user'])){
	header("location:keluar");
}
else{
	include "../../../../config/conn.php";
	include "../../../../config/library.php";
	include "../../../../config/fungsi_tanggal.php";
	include "../../../../config/fungsi_rupiah.php";
	$tanggal_awal2=$_GET[tanggal_awal];
	$tanggal_akhir2=$_GET[tanggal_akhir];
	
	$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_unit where id='$_SESSION[id_units]'"));

	$setting1=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting "));
	$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_invoice WHERE no_invoice='$_GET[no_invoice]'"));

	$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$d[id_pasien]'"));

	$a=explode(" ",$d['waktu_input']);
	$tanggal=DateToIndo($a[0]);
	$jam=$a[1];
	$invoice=$d['id'];
	echo"<html>
		<head>
			<style type='text/css'>
				@page { size:A4; margin: 1cm }
				@media print {
				  html, body {
				    width: 297mm;
				    height: 210mm;
				  }
									  
				body{
					font-family:calibri;
					font-size:14px;
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
					font-size:14px;
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
					<img src='../../../../images/$setting1[logo]' width='60px'>
				</div>
				<div class='aligncenter'>
					<span class='title'>$setting[nama]</span>
					
					<span class='telepon'>Telp. $setting[telepon] Fax. $setting[fax]</span>
				</div>
				
				<div class='alignright'>
				
				</div>
			</div>
			<div class='box-body'>
				<hr>
				<center><h3>Rekapitulasi Penerimaan</h3></center>
				
				<center>".DateToIndo($_GET[tanggal_awal])." s/d ". DateToIndo($_GET[tanggal_akhir]). "</center>
				
				<table style='margin:auto;width:100%;border-collapse:collapse;'>
					<thead>
						<tr>
						<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:50px;'>Tanggal/Jam</th>
										<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:50px;'>No. Invoice</th>
										<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:50px;'>Perusahaan</th>
										<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:50px;'>Nama Pasien</th>
										<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:50px;'>Issued by</th>
										<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:50px;'>Amount</th>
										<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:50px;'>Status</th>
										
						</tr>
					</thead>
					<tbody>";
								$JUMLAH_AMOUNT=0;
								$JUMLAH_BELUM=0;

									$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice WHERE id_unit='$_SESSION[id_units]' AND waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' AND status_issue='1' ORDER BY id");
									
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$r[id_kategori_harga_bayar]'"));
										$nama_perusahaan=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_pasien WHERE id='$r[id_pasien]'"));
										$nama_pasien=$a['nama'];
										
										if($r['id_users']==1){
											$nama_user="Administrasi";
										}
										else{
											$a=pg_fetch_array(pg_query($dbconn,"SELECT a.nama FROM master_karyawan a, auth_users b WHERE a.id=b.id_karyawan AND b.id_users='$r[id_users]'"));
											$nama_user=$a['nama'];
										}
										
										$amount=formatRupiah3($r['total']);
										
										
										if($r['status_bayar']=='Y'){
											$status="Bayar";
											$JUMLAH_AMOUNT+=$r['total'];
										}
										else{
											$status="Belum Bayar";
											$JUMLAH_BELUM+=$r['total'];
										}
										?>
										<tr>
											<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo "$tanggal $a[1]";?></td>
											<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo $r['no_invoice'];?></td>
											<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo $nama_perusahaan;?></td>
											<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo $nama_pasien;?></td>
											<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo $nama_user;?></td>
											<td style='border:1px solid #CCC; padding:4px 8px; text-align:right;'><?php echo $amount;?></td>
											<td style='border:1px solid #CCC; padding:4px 8px; text-align:center;'><?php echo $status;?></td>
											
										</tr>
										<?php
									}
									?>
								</tbody>
							
					
					</tbody>
					<tfoot>
						<tr>
							<td colspan='5' style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><b>TOTAL BAYAR</b>
							</td>
							<td style='border:1px solid #CCC; padding:4px 8px; text-align:right;'>
								<b><?php echo number_format($JUMLAH_AMOUNT,0, ',', '.'); ?></b>
							</td>
						</tr>
						<tr>
							<td colspan='5' style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><b>TOTAL BELUM BAYAR</b>
							</td>
							<td style='border:1px solid #CCC; padding:4px 8px; text-align:right;'>
								<b><?php echo number_format($JUMLAH_BELUM,0, ',', '.'); ?></b>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</body>
	</html>
<?php 
}
?>
