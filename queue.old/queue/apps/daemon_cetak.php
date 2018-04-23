<?php
		include "mysql_connect.php";

		$getData=pg_query("SELECT max(id) as id from data_cetak_antrian");
		$fetchData=pg_fetch_assoc($getData);
		$jumlah=$fetchData['id'];
		$next=$jumlah+=1;

		$results = pg_query($dbconn,"INSERT INTO data_cetak_antrian (id) 
						VALUES ('$next') RETURNING id");
		$next_counter = pg_fetch_row($results);
		$data['idle'] = "TRUE";


	    $data['next'] = $next_counter[0];
	    echo json_encode($data);
	    include 'mysql_close.php';
	
?>