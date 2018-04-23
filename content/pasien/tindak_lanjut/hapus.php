<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";

	pg_query($dbconn,"DELETE from pasien_tindak_lanjut WHERE id='$_POST[id]'");
	
	
		
	
}