<?php
	$loket = $_POST['loket'];

		include "mysql_connect.php";
		$rstClient = pg_query($dbconn,"SELECT * FROM data_antrian WHERE counter=NULL AND status=3 LIMIT 1");

		$rowClient = pg_fetch_array($rstClient);
		if(pg_num_rows($rstClient)>0){

			$id = $rowClient['id'];
			$results = pg_query($dbconn," UPDATE data_antrian SET counter='$loket', status=0 
										  WHERE id=$id ");
			$next_counter = $id;
			//update
		}else{
			//check jumlah
			$getDataCetak=pg_query("SELECT max(id) from data_cetak_antrian");
			$fetchDataCetak=pg_fetch_assoc($getDataCetak);
			$existedId=$fetchDataCetak['id']; //10

			$getDataGenerate=pg_query("SELECT max(id) from data_antrian");
			$fetchDataGenerate=pg_fetch_assoc($getDataGenerate);
			$nextId=$fetchDataGenerate['id']; //15

			if($nextId > $existedId)
			{

			}
			else
			{
				$getMaxData=pg_query("SELECT max(id) as id from data_antrian");
				$fetchData=pg_fetch_assoc($getMaxData);
				$jumlah=$fetchData['id'];
				$next=$jumlah+=1;

				$results = pg_query($dbconn,"INSERT INTO data_antrian (waktu,counter,status,id) 
						VALUES ('".date("Y-m-d H:i:s")."', '$loket' , 4, '$next') RETURNING id");
				$next_counter = pg_fetch_row($results);
				$data['idle'] = "TRUE";	
			}
			//insert
			
		}
		
	    $data['next'] = $next_counter[0];
	    echo json_encode($data);
	    include 'mysql_close.php';
	
?>