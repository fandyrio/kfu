<?php
session_start();

	include "config/conn.php";
	
	$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
	
	echo"<html>
		<head>
			
			<style type='text/css'>
				@page {
					size: 50mm 37mm;
					margin:0;
				}
									  
				body{
					font-family:Arial;
				}
			
				div.box-body{
					font-size:0.2rem;
					text-align:center;
				}
				
				span.nomor{
					margin:0;
					font-size:1rem;
					font-weight:bold;
					display:block;
				}
				title{
					font-size:2px;
				}
				
			</style>
			<title>Cetak Nomor Antrian Klinik</title>
			<script>
			function myFunction() {
				setTimeout(function () { window.print(); }, 500);
				window.onfocus = function () { setTimeout(function () { window.close(); }, 200); }
			}
			</script>
		</head>
		<body onload='window.print()' onfocus='window.close()'>
			<div class='box-body'>
				<img src='images/$setting[logo]' width='80px'><br><br>
				<span style='font-size:12px;'>SELAMAT DATANG<br>
				NO. ANTRIAN ANDA</span><br>
				<span class='nomor'>$_GET[id]</span>
				<span style='font-size:12px;'>TERIMA KASIH<br>
				MAAF TELAH MENUNGGU</span>
			</div>
		</body>

	</html>";
?>
