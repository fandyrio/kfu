<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header("location:keluar");
}
else{
	include "../../config/conn.php";
	include "../../config/library.php";
	include "../../config/fungsi_tanggal.php";
	
	$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_unit"));
	$p=pg_fetch_array(pg_query($dbconn,"SELECT no_rm, nama FROM master_pasien WHERE no_rm='$_GET[no_rm]'"));
	$a=pg_fetch_array(pg_query($dbconn,"SELECT b.waktu_input FROM antrian a, kunjungan b WHERE a.id_kunjungan=b.id AND a.no_antrian='$_GET[no_antrian]'"));
	
	$a=explode(" ",$a['waktu_input']);
	$tanggal=DateToIndo2($a[0]);
	echo"<html>
		<head>
			<style type='text/css'>
				@page { size:A4; margin: 1cm }
									  
				body{
					font-family:Times;
					font-size:14px;
				}
			
				
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
			<table>
				<tr>
					<td colspan='3' id='barcode'><img src='barcode.php?text=$p[no_rm]&size=20'></td>
				</tr>
				<tr>
					<td width='100px'>Nama</td>
					<td width='10px'>:</td>
					<td>$p[nama]</td>
				</tr>
				<tr>
					<td>Tanggal Registrasi</td>
					<td>:</td>
					<td>$tanggal</td>
				</tr>
			</table>
		</body>
	</html>";

}
?>
