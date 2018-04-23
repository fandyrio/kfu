<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$symptomList=$_POST['symptomList'];
$explode=explode(",", $symptomList);
$numOfSympArr=count($explode)-1;
var_dump(trim($symptomList," "));

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

			for($x=0;$x<=$numOfSympArr;$x++)
			{
				if($explode[$x]!="")
				{
					$nameArr="idSymptom".$explode[$x];
					$insertPasienKeluhanDetail=pg_query("INSERT INTO pasien_keluhan_detail (id_pasien_keluhan, id_symptom) 
					values('$row[0]', '$_POST[$nameArr]')");
				}
				
			}
}