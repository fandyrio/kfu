<?php
switch($_GET['act'])
{
	case "baru": 
	    $id_unit= $_SESSION['id_unit'];
		$id_kategori_harga = $_POST['id_perusahaan'];
		$harga = 'ARRAY['. implode(',', $_POST['total']).']';
    	$id_tindakan = 'ARRAY['. implode(',', $_POST['check']).']';


		$row = pg_fetch_row($res); 
		$sql =pg_query($dbconn, "INSERT INTO tindakan_kategori_harga_unit (id_kategori_harga, id_unit, harga, id_tindakan )  select $id_kategori_harga , $id_unit, *
					from unnest($harga, $id_tindakan)");
	
	break;

	case "edit":
	$id= $_POST['id'];
	$harga = $_POST['harga'];		

	pg_query($dbconn,"UPDATE tindakan_kategori_harga_unit set harga='$harga' WHERE id = $id");

	break;

	case "delete";

		$id = $_POST["id"];
		$res=pg_query($dbconn,"DELETE FROM tindakan_kategori_harga_unit WHERE id = '$id'  ");

	break;
}

?>