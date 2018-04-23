<?php

	include "mysql_connect.php";
	$date = date("Y-m-d");
	$results = pg_query($dbconn,"SELECT Max(id) as id FROM data_cetak_antrian");
	$row = pg_fetch_array($results);
	if ($row['id'] == NULL) {
    	$data = array('next' => 0);
	} else {
    	$data = array('next' => $row['id']);
	}
    echo json_encode($data);
	include 'mysql_close.php';

?>