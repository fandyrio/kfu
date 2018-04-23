<?php

    	include "mysql_connect.php";
    	if(isset($_POST['next_current']) and ($_POST['next_current'] != NULL)){
    		$cek_request_counter = pg_query($dbconn,"SELECT count(*) as count FROM data_antrian WHERE status=4");
    		$cek_request_counter_row = pg_fetch_array($cek_request_counter);
    		if ($cek_request_counter_row['count'] > 0) {
		    	$rstC = pg_query($dbconn,"SELECT id FROM data_antrian WHERE status=4 LIMIT 1");
				$rowC = pg_fetch_array($rstC);
				$id = $rowC['id'];
    			$results = pg_query($dbconn,"UPDATE data_antrian SET status=0 WHERE status=4 LIMIT 1");
			    echo json_encode( array('next'=> $id) );
    		}else{
				//insert
				$results = pg_query("INSERT INTO data_antrian (waktu,status) VALUES ('".date("Y-m-d H:i:s")."',3) RETURNING id");
				$id = pg_fetch_row($results);
			    echo json_encode( array('next'=> $id[0]) );
			}
    	}else{
	    	$rstClient = pg_query($dbconn,"SELECT count(*) as count FROM data_antrian WHERE status != 4");
			$rowClient = pg_fetch_array($rstClient);
			if($rowClient['count']>0){
				$jmlClient = $rowClient['count'];
			}else{
				$jmlClient = 0;
			}
		    echo json_encode( array('next'=> $jmlClient) );
		}
    	include 'mysql_close.php';
