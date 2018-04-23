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
			//insert
			$results = pg_query($dbconn,"INSERT INTO data_antrian (waktu,counter,status) 
						VALUES ('".date("Y-m-d H:i:s")."', '$loket' , 4) RETURNING id");
			$next_counter = pg_fetch_row($results);
			$data['idle'] = "TRUE";
		}
		
	    $data['next'] = $next_counter[0];
	    echo json_encode($data);
	    include 'mysql_close.php';
	
?>