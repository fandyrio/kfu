<?php 

	include "mysql_connect.php";
	$data = array();
	if (isset($_POST) and count($_POST) > 0){
		if (isset($_POST['db']) and $_POST['db']=="queue") {
			$results = pg_query($dbconn,"SELECT * FROM data_antrian ORDER BY id ASC LIMIT 1");
			while ($row = pg_fetch_array($results)) {
			    $data['id'] = $row['id'];
			    $data['counter'] = $row['counter'];
			    $data['waktu'] = $row['waktu'];
			    $data['status'] = $row['status'];
			}
			echo json_encode($data);	
		}else{
			$jmlloket = $_POST['jmlloket'];
			$results = pg_query($dbconn,"DELETE FROM client_antrian;");
			for ($i=1; $i <= $jmlloket ; $i++) { 
				$results = pg_query($dbconn,'INSERT INTO client_antrian (client) VALUES ('.$i.')');
			}
			echo json_encode(array("status"=>TRUE));		
		}
	} else {
		$results = pg_query($dbconn,'SELECT  count(*) as jumlah_loket FROM client_antrian');
		while ($row = pg_fetch_assoc($results)) {
		    $data['jumlah_loket'] = $row['jumlah_loket'];
		}
    	echo json_encode($data);
	}
	include 'mysql_close.php';
