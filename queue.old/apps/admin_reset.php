<?php

	include "mysql_connect.php";
	$rstClient = pg_query($dbconn,"TRUNCATE TABLE data_antrian restart identity");
	$rstClient1 =pg_query($dbconn,"TRUNCATE TABLE data_cetak_antrian restart identity");
    echo json_encode( array('status'=> "Data Berhasil di Reset") );
	include 'mysql_close.php';
?>