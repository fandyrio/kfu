<?php 
	$data = array();

    	include "mysql_connect.php";
		$results = pg_query($dbconn,'SELECT DISTINCT(counter) as counter FROM data_antrian');
		if ( pg_num_rows($results)>0) {
			while ($row = pg_fetch_array($results)) {
			    $data[] = $row['counter'];
			}
		}
	    echo json_encode($data);
	    include 'mysql_close.php';
   ?>