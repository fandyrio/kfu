<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../config/library.php";
	include "../../config/fungsi_tanggal.php";
	$tanggal_lahir=DateToEng($_POST['tanggal_lahir']);
	
	$diff=beda_waktu($tanggal_lahir,$tgl_sekarang);
	echo"$diff[y] tahun, $diff[m] bulan, $diff[d] hari";
}
?>