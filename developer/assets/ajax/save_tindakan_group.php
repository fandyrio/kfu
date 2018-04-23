<?php
 	    $nama = $_POST['nama'];
	    $kode = $_POST['kode'];    

		$res=pg_query($dbconn,"INSERT INTO tindakan_jenis (nama, kode) VALUES('".$nama."', '$kode')");

		if($res){
			echo "success";
		}
		

?>