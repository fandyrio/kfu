<?php
session_start();
//error_reporting(0);
var_dump($_SESSION['id_units']);
if (empty($_SESSION['login_user'])){
	header("location:keluar");
}
else{
	include "../../../../config/conn.php";
	include "../../../../config/library.php";
	include "../../../../config/fungsi_tanggal.php";
	include "../../../../config/fungsi_rupiah.php";
	
	$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_unit where id='$_SESSION[id_units]'"));
	$query="SELECT nama from master_karyawan  WHERE id='$setting[id_dokter]' ";
	$view_dokter=pg_fetch_array(pg_query($dbconn,$query));
	$dokter_pengirim = $view_dokter['nama'];

	$setting1=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting "));
	
	$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_payment WHERE id='$_GET[id]'"));
	$tanggal_bayar=DateToIndo2($d['waktu_input']);
	$jam_bayar=$d['jam_input'];


	$v=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_invoice WHERE id='$d[id_invoice]'"));
	$id_invoice=$d['id_invoice'];
	$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$v[id_pasien]'"));

	if($p['jenkel']==1){
		$jenkel="<i class='icon-user'></i>";
		$icon_jenkel="<i class='icon-symbol-male'></i>";
	}
	else{
		$jenkel="<i class='icon-user-female'></i>";
		$icon_jenkel="<i class='icon-symbol-female'></i>";
	}
	if($p['foto']!=''){
		$gambar="images/pasien/upload_$p[foto]";
	}
	else{
		$gambar="images/default.png";
	}
	$nama_pembayar=$p['nama'];
	$no_handphone=$p['no_handphone'];
	$tanggal_lahir=DateToIndo2($p['tanggal_lahir']);

	$diskon=$d['diskon'];
	$diskon2=formatRupiah3($diskon);

	$total=$d['harga_invoice'];
	$total2=formatRupiah3($total);

	//$total_net=$total-$diskon;
	$total_net2=formatRupiah3($d['harga_invoice_diskon']);
	echo"<html>
		<head>
			<style type='text/css'>
				@page { size:16.4cm 21cm; margin: 0.2cm }
									  
				body{
					font-family:Times;
					font-size:8px;
				}
			
				div.box-header{
					text-align:center;
					padding-bottom:10px;
					margin-top:10px;
				}
				
				div.box-body{
					font-size:10px;
					clear:both;
					margin-top:10px;
				}
				
				span.title{
					margin:0;
					font-size:10px;
					font-weight:bold;
					display:block;
				}
				
				span.alamat{
					margin:0;
					font-size:8px;
					display:block;
				}
				
				span.telepon{
					font-size:8px;
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
					font-size:8px;
				}
				
				table tr td{
					font-size:8px;
				}
				
				table thead tr th{
					font-size:9px;
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
				<!---<div style='left:20px;position:fixed;'>
					<img src='images/$setting1[logo]' width='70px'>
				</div>-->
				<div class='alignleft' style='margin-left:4cm; margin-top:1.1cm;'>
					<span class='title'>$setting[nama]</span>
					<span class='telepon'>Telp. $setting[telepon] Fax. $setting[fax]</span>
					<span class='alamat'>Alamat $setting[alamat]</span>
				</div>
				
				<div class='alignright'>
					<B>BUKTI PEMBAYARAN</B>
				</div>
			</div>
			<div class='box-body'>
				<br>
				<hr>
				<table>
					<tr>
						<td>No. Payment</td><td>:</td><td><b>#$d[no_payment]</b></td>
						<td width='150px'></td>
						<td>Nama Pembayar</td><td>:</td><td>$d[nama_pembayar]</td>
					</tr>
					<tr>
						<td>No. Invoice</td><td>:</td><td><b>#$v[no_invoice]</b></td>
						<td></td>
						<td>No. Handphone</td><td>:</td><td>$d[no_handphone]</td>
					</tr>
					<tr>
						<td>Nama Pasien</td><td>:</td><td>$p[nama] </td>
						<td></td>
						<td>Catatan</td><td>:</td><td>$d[catatan]</td>
					</tr>
					<tr>
						<td>No. RM</td><td>:</td><td>$p[no_rm]</td>
						<td></td>
						<td>Waktu Pembayaran</td><td>:</td><td>$tanggal_bayar $jam_bayar</td>
					</tr>
				</table>
				<br>
				<table style='width:100%;border-collapse:collapse;'>
					<thead>
						<tr>
							<th style='border:1px solid #CCC; padding:2px 4px; text-align:center; width:100px;'>Tanggal</th>
							<th style='border:1px solid #CCC; padding:2px 4px; text-align:center;'>Item Pemeriksaan</th>
							<th style='border:1px solid #CCC; padding:2px 4px; text-align:center; width:50px;'>Qty</th>
							<th style='border:1px solid #CCC; padding:2px 4px; text-align:center; width:80px;' colspan='2'>Harga</th>
							<th style='border:1px solid #CCC; padding:2px 4px; text-align:center; width:100px;' colspan='2'>Amount</th>
						</tr>
					</thead>
					<tbody>";
						$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_invoice='$id_invoice' AND id_kategori_harga='$d[id_kategori_harga]'");

						$total=0;
						while($r=pg_fetch_array($tampil)){
							$a=explode(" ",$r['waktu_input']);
							$tanggal=DateToIndo2($a[0]);
							$jam=$a[1];

							if($r['jenis']=='E'){
											
										$a=pg_fetch_array(pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$r[id_detail]' order by d.id_detail "));

										
											$nama_transaksi="MCU - $a[nama_paket]";
											$catatan=$a['catatan'];
											
										}
										
										if($r['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
											$nama_transaksi="ST - $a[nama]";
											$catatan=$a['catatan'];	
											
										}
										elseif($r['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
											$nama_transaksi="MT - $a[nama]";
											$catatan=$a['catatan'];
										}
										elseif($r['jenis']=='P'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_paket WHERE id='$r[id_detail]'"));
											$nama_transaksi="PT - $a[nama]";
											$catatan=$a['catatan'];
										}
										elseif($r['jenis']=='N'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_detail]'"));
											$nama_transaksi="ST - $a[nama]";
											$catatan=$a['catatan'];
										}
							
							
							$harga=formatRupiah3($r['harga']);
							$subtotal=$r['harga']*$r['kuantitas'];
							$total+=$subtotal;
							$subtotal=formatRupiah3($subtotal);
							echo"
							<tr>
								<td style='border:1px solid #CCC; padding:2px 4px; text-align:left;'>$tanggal</td>
								<td style='border:1px solid #CCC; padding:2px 4px; text-align:left;'>$nama_transaksi</td>
								<td style='border:1px solid #CCC; padding:2px 4px; text-align:right;'>$r[kuantitas]</td>
								<td style='border-right:none; padding:2px 4px; text-align:left; border-bottom:1px solid #CCC;'>Rp</td>
								<td style='border:1px solid #CCC; border-left:none; padding:2px 4px; text-align:right;'>$harga</td>
								<td style='border-right:none; padding:2px 4px; text-align:left; border-bottom:1px solid #CCC;'>Rp</td>
								<td style='border:1px solid #CCC; border-left:none; padding:2px 4px; text-align:right;'>$subtotal</td>
							</tr>
							";
						}	
						$total=formatRupiah3($total);
					echo"
					</tbody>
					<tfoot>
						<tr>
							<td colspan='5' style='border:1px solid #CCC; padding:2px 4px; text-align:left;'><b>TOTAL</b>
							</td>
							<td style='border-right:none; padding:2px 4px; text-align:left;  border-bottom:1px solid #CCC;'><b>Rp</b></td>
							<td style='border:1px solid #CCC; border-left:none; padding:2px 4px; text-align:right;'><b>$total2</b></td>
						</tr>
						
						<tr>
							<td colspan='5' style='border:1px solid #CCC; padding:2px 4px; text-align:left;'><b>DISKON</b>
							</td>
							<td style='border-right:none; padding:2px 4px; text-align:left;  border-bottom:1px solid #CCC;'><b>Rp</b></td>
							<td style='border:1px solid #CCC; border-left:none; padding:2px 4px; text-align:right;'><b>$diskon2</b></td>
						</tr>
						
						<tr>
							<td colspan='5' style='border:1px solid #CCC; padding:2px 4px; text-align:left;'><b>TOTAL NET</b>
							</td>
							<td style='border-right:none; padding:2px 4px; text-align:left;  border-bottom:1px solid #CCC;'><b>Rp</b></td>
							<td style='border:1px solid #CCC; border-left:none; padding:2px 4px; text-align:right;'><b>$total_net2</b></td>
						</tr>
					</tfoot>
				</table>
				
				<table style='float:right;''>
					<tr>
					
					</tr>
					<tr style='text-align: center; font-weight:bold;'><td>Kasir</td></tr>
					<tr><td></td></tr>
					<tr><td>...........................................</td></tr>
					<tr style='text-align: center;''><td>Tanggal ".date('Y-m-d h:i:s')."</td></tr>
				</table>
				<br>
				<center>
					<img src='images/lunas.jpg' width='100px'>
				</center>
			</div>
		</body>
	</html>";

}
?>
