<?php
	//var_dump($_GET['id']);

	$id=$_GET['id'];

	$sql = pg_query($dbconn, "delete from po_ln where id='$id'");

	//var_dump("delete from q_ln_temp where id='$id'");
?>