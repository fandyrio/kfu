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




	pg_query($dbconn,"DELETE from pasien_keluhan WHERE id='$_POST[id]'");
	pg_query($dbconn,"DELETE from pasien_keluhan_detail WHERE id_pasien_keluhan='$_POST[id]'");
	echo"Data sudah di hapus";
	//var_dump("DELETE from pasien_keluhan_detail WHERE id_pasien_keluhan='$_POST[id]'");
		
	
}