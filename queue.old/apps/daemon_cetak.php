<?php
		include "mysql_connect.php";
		$results = pg_query($dbconn,"INSERT INTO data_cetak_antrian (id) 
						VALUES (DEFAULT) RETURNING id");
		$next_counter = pg_fetch_row($results);
		$data['idle'] = "TRUE";


	    $data['next'] = $next_counter[0];
	    echo json_encode($data);
	    include 'mysql_close.php';
	
?>