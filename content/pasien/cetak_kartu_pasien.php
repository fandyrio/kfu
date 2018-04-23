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
	$p=pg_fetch_array(pg_query($dbconn,"SELECT no_rm, nama, tanggal_lahir FROM master_pasien WHERE no_rm='$_GET[no_rm]'"));
	$tanggal_lahir=DateToIndo($p['tanggal_lahir']);
	
	echo"<html>
		<head>
			<style type='text/css'>
							  
				.body{
					margin:auto 0px;
					color: #000;
					font-family: calibri;
					font-size: 160%;
					
				}
				.head_card{
					width: 100%;
					font-size: 8px;
					font-family: calibri;
					text-align: center;
					line-height: 0.5 em;
				}
				.content_card{
					width: 100%;
					font-size: 20px;
					 font-family: calibri;
					 font-weight: bold;
					 text-align: center;

					 
				}
				#lahir{
					width: 100%;
					font-size: 14px;
					font-family: calibri; 
					font-weight: 100;
					text-align: center;

					 
				}
				#barcode{
					width: 100%;
					font-size: 14px;
					font-family: calibri; 
					font-weight: 100;
					text-align: right;
					right: 0px;	 
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
			<div>
				<div style='float:left; position:fixed; top:5px;'>
					<img src='images/$setting[logo]'  height='47px' width='75px'>
				</div>
				<div style='float:right; width: 90%;'>
					<table class='head_card'>
						<tr>
							<td><b>$setting[nama]</b></td>
						</tr>
						<tr>
							<td>$setting[alamat]</td>
						</tr>
						<tr>
							<td>Telp. $setting[telepon] Fax. $setting[fax]</td>
						</tr>
						<tr>
							
						</tr>
					</table>
				</div>
				<hr style='position: relative; width: 100%;'>	
				<table  class='content_card' style='margin-top:10px;'>											
					<tr>
						<td>$p[nama]</td>
					</tr>
					<tr id='lahir'>												
						<td >Tgl Lahir : $tanggal_lahir</td>
					</tr>
					<tr>												
						<td id='barcode'><img src='barcode.php?text=$p[no_rm]' /></td>
					</tr>
				</table>
			</div>	
		</body>
	</html>";

}
?>
