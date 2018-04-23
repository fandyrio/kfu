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

	$terkontrol =  (isset($_POST['terkontrol'])?'Y':'N');
	$dirujuk =  (isset($_POST['dirujuk'])?'Y':'N');
	$meninggal =  (isset($_POST['meninggal'])?'Y':'N');
	$

	$res=pg_query($dbconn,"INSERT INTO pasien_tindak_lanjut (id_pasien, id_kunjungan, status_terkontrol, status_dirujuk, id_tindak_lanjut, meninggal_dunia, waktu_input,id_rs, id_unit) VALUES (
		'$_POST[id_pasien]','$_POST[id_kunjungan]','$terkontrol','$dirujuk','$_POST[id_tindak_lanjut]','$meninggal','$tgl_sekarang $jam_sekarang', '$_POST[rujukan_id]', '$_SESSION[id_units]')");

}