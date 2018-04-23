<?php
switch($_GET['act'])
{
	case "baru":	
		$id_unit= $_SESSION['id_units'];
		$id_kategori_harga = $_SESSION["id_perusahaan"] ;
		$harga = 'ARRAY['. implode(',', $_POST['total']).']';
    	$id_multi = 'ARRAY['. implode(',', $_POST['multi']).']';

		
		$res =pg_query($dbconn, "INSERT INTO lab_analysis_group_unit (id_kategori_harga, id_unit, harga_unit,id_lab_analysis_group  )  select $id_kategori_harga , $id_unit, *
					from unnest($harga, $id_multi)");

	break;

	case "delete":
	$id= $_POST['id'];		
	$result=pg_query($dbconn,"DELETE FROM lab_analysis_group_unit WHERE id = $id");

	break;


	case "edit":
	$id= $_POST['id'];
	$harga = $_POST['harga'];		
	pg_query($dbconn,"UPDATE lab_analysis_group_unit set harga_unit='$harga' WHERE id = '$id'");
	break;
}

?>