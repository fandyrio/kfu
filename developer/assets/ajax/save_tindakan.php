<?php
 		 $nama = $_POST['nama'];
	    $kode = $_POST['kode'];
	    $harga_material = $_POST['harga_material'];
	    $harga_jasa = $_POST['harga_jasa'];
	    $id_jenis = $_POST['id_jenis'];
	  /*  if (!isset($unit_cost) || empty($unit_cost)) {
				    $unit_cost = 0;
				   
			} 
			else{
				    $unit_cost = "'" .pg_escape_string($unit_cost) . "'";
				   
			}

	    $harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
    	$id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';*/

    	


		$res=pg_query($dbconn,"INSERT INTO tindakan(kode, nama, harga_jasa, harga_material, id_jenis) 
			VALUES('$kode','".$nama."','$harga_jasa','$harga_material', '$id_jenis')");

	

		/*$row = pg_fetch_row($res); 

		$sql =pg_query($dbconn, "INSERT INTO tindakan_kategori_harga (id_tindakan, harga, id_kategori_harga ) 
                         select $row[0] ,*
					from unnest($harga, $id_layanan)");*/

		

		

?>