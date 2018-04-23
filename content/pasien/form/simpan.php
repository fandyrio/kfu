<?php 
	session_start();
	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";

	//$file= $_POST['nama_path'];
	$file=uniqid().".php";
    file_put_contents('../../../data/dokumen/'.$file,$_POST['file']);
	

	$result=pg_query($dbconn,"INSERT INTO pasien_form (id_kunjungan, id_pasien, id_unit, tanggal_input, id_users, nama_path) VALUES ('$_POST[id_kunjungan]', '$_POST[id_pasien]', '$_SESSION[id_units]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]',  '$file') ");


?>