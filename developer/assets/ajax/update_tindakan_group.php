<?php
 	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$kode = $_POST['kode'];

	$result=pg_query($dbconn,"UPDATE tindakan_jenis SET 
	nama='".$nama."', kode='".$kode."'
	WHERE id = $id
	");


	echo "sucesss";

		

?>