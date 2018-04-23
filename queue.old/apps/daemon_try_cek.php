<?php 
	$id = $_POST['counter']; //id
	$loket = $_POST['loket']; // counter

		include "mysql_connect.php";		
		$hasil = pg_query($dbconn,"select * from data_antrian where id='$id' and counter='$loket' ");		
		$data = pg_fetch_array($hasil);
		echo json_encode(array('huft' => $data['status']));
		include 'mysql_close.php';
	
?>