<?php
	
	//var_dump($_GET['id']);

	$id=$_GET['id'];
	

	$sql = pg_query($dbconn, "delete from lab_analisis_referal_range where id='$id'");
	

	//var_dump("delete from lab_analisis_referal_range_temp where id=$id");
?>