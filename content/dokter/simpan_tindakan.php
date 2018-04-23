<?php
session_start();
include "../../config/conn.php";
switch($_GET['act'])
{
	case "baru": 
	    $id_unit= $_SESSION['id_units'];
		$id_karyawan = $_SESSION['id_dokter'];
		$persen_dokter = 'ARRAY['. implode(',', $_POST['persen_dokter']).']';
		$persen_perawat = 'ARRAY['. implode(',', $_POST['persen_perawat']).']';
		$harga = 'ARRAY['. implode(',', $_POST['harga']).']';
    	$id_tindakan = 'ARRAY['. implode(',', $_POST['check']).']';

		$sql =pg_query($dbconn, "INSERT INTO tindakan_dokter_unit (id_karyawan, id_unit, persen_dokter, id_tindakan, harga, persen_perawat )  select $id_karyawan , $id_unit, *
					from unnest($persen_dokter, $id_tindakan, $harga, $persen_perawat)");



	
	break;

	case "edit":
	$id= $_POST['id'];
	$persen_dokter = $_POST['persen_dokter'];
	$persen_perawat = $_POST['persen_perawat'];
	$harga = $_POST['harga'];		

	pg_query($dbconn,"UPDATE tindakan_dokter_unit set persen_dokter='$persen_dokter', harga='$harga', persen_perawat='$persen_perawat' WHERE id = $id");

	

	break;

	case "delete";

		$id = $_POST["id"];
		$res=pg_query($dbconn,"DELETE FROM tindakan_dokter_unit WHERE id = '$id'  ");

	break;
}

?>