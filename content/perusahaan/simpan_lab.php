<?php
switch($_GET['act'])
{
	case "baru":
		$id_unit= $_SESSION['id_units'];
		$id_kategori_harga = $_SESSION["id_perusahaan"] ;
		$harga = 'ARRAY['. implode(',', $_POST['total']).']';
    	$id_lab = 'ARRAY['. implode(',', $_POST['check']).']';

		
		$sql =pg_query($dbconn, "INSERT INTO lab_analysis_kategori_harga_unit (id_kategori_harga, id_unit, harga,id_lab_analysis  )  select $id_kategori_harga , $id_unit, *
					from unnest($harga, $id_lab)");

	

	break;

	case "delete":

	$id= $_POST['id'];		
	pg_query($dbconn,"DELETE FROM lab_analysis_kategori_harga_unit WHERE id = $id");

	var_dump("DELETE FROM lab_analysis_kategori_harga_unit WHERE id = $id");

	break;

	case "edit":
	$id= $_POST['id'];
	$harga = $_POST['harga'];		

	pg_query($dbconn,"UPDATE lab_analysis_kategori_harga_unit set harga='$harga' WHERE id = $id");

	

	break;
}

?>