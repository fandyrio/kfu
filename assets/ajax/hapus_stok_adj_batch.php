<?php
	//var_dump($_GET['id']);

	$id=$_POST['id'];
	
	$sql = pg_query($dbconn, "delete from stok_adj_batch where id='$id'");

	//var_dump("delete from q_ln_temp where id='$id'");
?>