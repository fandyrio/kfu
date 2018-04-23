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




	$res=pg_query($dbconn,"INSERT INTO pasien_keluhan (id_pasien, id_kunjungan, id_users, id_unit, id_body, id_lokasi, lama_keluhan,merokok, catatan) VALUES (
		'$_POST[id_pasien]','$_POST[id_kunjungan]','$_SESSION[login_user]','$_SESSION[id_units]','$_POST[id_body]','$_POST[id_lokasi]','$_POST[hari]','$_POST[rokok]', '$_POST[catatan]') RETURNING id");
		
	$row = pg_fetch_row($res);
		
	if (!isset($_POST['id_s']) || empty($_POST['id_s'])) {
				  
		} 
		else{
			 $id_s = 'ARRAY['. implode(',', $_POST['id_s']). ']'; 
			
			$result = pg_query($dbconn, "INSERT INTO pasien_keluhan_detail (id_pasien_keluhan, id_symptom) 
			select $row[0], *	from unnest($id_s)"); 

			var_dump("INSERT INTO pasien_keluhan_detail (id_pasien_keluhan, id_symptom) 
			select $row[0], *	from unnest($id_s)");	

			
		
		}

}