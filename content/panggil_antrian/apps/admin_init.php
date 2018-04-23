<?php

    	include "mysql_connect.php";
    	$rstClient = pg_query($dbconn,"SELECT count(*) as count FROM client_antrian");
		$rowClient = pg_fetch_array($rstClient);
		if($rowClient['count']>0){
			$jmlClient = $rowClient['count'];
		}else{
			$jmlClient = 0;
		}
	    echo json_encode( array('client'=> $jmlClient) );
    	include 'mysql_close.php';
?>