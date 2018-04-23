<?php
session_start();
//error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../../config/conn.php";
	include "../../../../config/library.php";
	include "../../../../config/fungsi_tanggal.php";

	$module=$_GET['module'];
	$act=$_GET['act'];
	
	if ($module=='keuangan_customer_klaim' AND $act=='input'){
		$tanggal_klaim=DateToEng($_POST['tanggal_klaim']);
		pg_query($dbconn,"INSERT INTO transaksi_klaim (id_pasien, id_rumahsakit, id_status_klaim, id_user, waktu_input, id_kategori_harga, tanggal_klaim, jumlah, nama_dokter, catatan, id_unit) VALUES ('$_POST[id_pasien]', '$_POST[id_rumahsakit]', '$_POST[id_status_klaim]', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$_POST[id_kategori_harga]', '$tanggal_klaim', '$_POST[jumlah]', '$_POST[nama_dokter]', '$_POST[catatan]', '$_SESSION[id_units]')");
		header("location:keuangan-customer-klaim");
	}
	
	elseif ($module=='keuangan_customer_klaim' AND $act=='update'){
		$tanggal_klaim=DateToEng($_POST['tanggal_klaim']);
		pg_query($dbconn,"UPDATE transaksi_klaim SET id_rumahsakit='$_POST[id_rumahsakit]', id_status_klaim='$_POST[id_status_klaim]', id_user='$_SESSION[login_user]', waktu_input='$tgl_sekarang $jam_sekarang', id_kategori_harga='$_POST[id_kategori_harga]', tanggal_klaim='$tanggal_klaim', jumlah='$_POST[jumlah]', nama_dokter='$_POST[nama_dokter]', catatan='$_POST[catatan]' WHERE id='$_POST[id]'");
		
		header("location:keuangan-customer-klaim");
	}
	
	elseif ($module=='keuangan_customer_klaim' AND $act=='delete'){
		pg_query($dbconn,"DELETE FROM transaksi_klaim WHERE id='$_GET[id]'");
		header("location:keuangan-customer-klaim");
	}
	pg_close($dbconn);
}
?>