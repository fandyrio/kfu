<?php
	//var_dump($_GET['id']);

	$id=$_GET['id'];

	$sql = pg_query($dbconn, "delete from rq_ln_temp where id='$id'");

	//var_dump("delete from rq_ln_temp where id='$id'");
?>