<?php 
	$id = $_POST['counter']; //id
	$loket = $_POST['loket']; // counter
	
	include "mysql_connect.php";		
	$hasil = pg_query($dbconn,"select * from data_antrian where id='$id' and counter='$loket'");		
	$data = pg_fetch_array($hasil);

	$getDataCetak=pg_query("SELECT max(id) as id from data_cetak_antrian");
	$fetchDataCetak=pg_fetch_assoc($getDataCetak);
	$existedId=$fetchDataCetak['id']; //10

	$getDataGenerate=pg_query("SELECT max(id) as id from data_antrian");
	$fetchDataGenerate=pg_fetch_assoc($getDataGenerate);
	$nextId=$fetchDataGenerate['id']; //15
	
		if($nextId >= $existedId)
		{
			$display="hide";
		}
		else
		{
			$display="show";
		}




	echo json_encode(array('huft' => $data['status'], 'status'=>$display));
	include 'mysql_close.php';

?>