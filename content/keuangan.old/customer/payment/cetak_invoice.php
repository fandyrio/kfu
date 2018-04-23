<?php
session_start();
//error_reporting(0);
if (empty($_SESSION['login_user'])){
	header("location:keluar");
}
else{
	include "../../../../config/conn.php";
	include "../../../../config/library.php";
	include "../../../../config/fungsi_tanggal.php";
	include "../../../../config/fungsi_rupiah.php";
	
	$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_unit"));
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
									  
				body{
					font-family:Times;
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
					<img src='images/$setting[logo]' width='60px'>
				</div>
				<div class='aligncenter'>
					<span class='title'>$setting[nama]</span>
					<span class='alamat'>$setting[alamat]</span>
					<span class='telepon'>Telp. $setting[telepon] Fax. $setting[fax]</span>
				</div>
				
				<div class='alignright'>
				
				</div>
			</div>
			<div class='box-body'>
				<hr>
				<br>
				<table>
					<tr>
						<td>Tanggal/Jam</td><td>:</td><td>$tanggal $jam</td>
					</tr>
					<tr>
						<td>No. Invoice</td><td>:</td><td><b>$d[no_invoice]</b></td>
					</tr>
					<tr>
						<td>Nama Pasien</td><td>:</td><td>$p[nama] ($p[no_rm])</td>
					</tr>
				</table>
				<br>
				<table style='width:100%;border-collapse:collapse;'>
					<thead>
						<tr>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:100px;'>Tanggal</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Detail</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:50px;'>Qty</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:80px;'>Harga</th>
							<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:100px;'>Amount</th>
						</tr>
					</thead>
					<tbody>";
						$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_invoice='$d[id]'");
						$total=0;
						while($r=pg_fetch_array($tampil)){
							$a=explode(" ",$r['waktu_input']);
							$tanggal=DateToIndo2($a[0]);
							$jam=$a[1];
							
							if($r['jenis']=='LO'){
								$a=pg_fetch_array(pg_query($dbconn,"SELECT no_referensi, catatan FROM pasien_laborder WHERE id='$r[id_detail]'"));
								$nama_transaksi="Lab Order - No. Ref $a[no_referensi]";
								$catatan=$a['catatan'];
							}
							elseif($r['jenis']=='BPT'){
								$a=pg_fetch_array(pg_query($dbconn,"SELECT b.nama_paket, a.catatan FROM pasien_billing_paket a, billing_paket b WHERE a.id_billing_paket=b.id AND a.id='$r[id_detail]'"));
								
								$nama_transaksi="$a[nama_paket]";
								$catatan=$a['catatan'];
							}
							elseif($r['jenis']=='BT'){
								$a=pg_fetch_array(pg_query($dbconn,"SELECT a.nama, b.catatan FROM tindakan a, pasien_tindakan b WHERE a.id=b.id_tindakan AND b.id='$r[id_detail]'"));
								$nama_transaksi="Tindakan - ".$a['nama'];
								$catatan=$a['catatan'];
							}
							
							$harga=formatRupiah3($r['harga']);
							$subtotal=$r['harga']*$r['kuantitas'];
							$total+=$subtotal;
							$subtotal=formatRupiah3($subtotal);
							echo"
							<tr>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'>$tanggal</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'>$nama_transaksi</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:right;'>$r[kuantitas]</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:right;'>$harga</td>
								<td style='border:1px solid #CCC; padding:4px 8px; text-align:right;'>$subtotal</td>
							</tr>
							";
						}	
						$total=formatRupiah2($total);
					echo"
					</tbody>
					<tfoot>
						<tr>
							<td colspan='4' style='border:1px solid #CCC; padding:4px 8px; text-align:center;'><b>TOTAL</b>
							</td>
							<td style='border:1px solid #CCC; padding:4px 8px; text-align:right;'>
								<b>$total</b>
							</td>
						</td>
					</tfoot>
				</table>
			</div>
		</body>
	</html>";

}
?>
