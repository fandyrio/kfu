<?php 
	$id = $_POST['counter']; //id
	$loket = $_POST['loket']; // counter

		include "mysql_connect.php";
		$results = pg_query($dbconn,"UPDATE data_antrian SET waktu='".date("Y-m-d H:i:s")."',status=0 WHERE id='$id' 
						and counter='$loket'");
		
		$hasil = pg_query($dbconn,"select * from data_antrian where id='$id' and counter='$loket'");
		//echo 'select * from data_antrian where id='.$id.' and counter='.$loket.'';

		var_dump("select * from data_antrian where id='$id' and counter='$loket'");
		
		$data = pg_fetch_array($hasil);
		echo json_encode(array('huft' => $data['status']));
		include 'mysql_close.php';
	
?>