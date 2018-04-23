<?php
	//var_dump($_GET['id']);

	$id=$_POST['id'];
	

	$sql = pg_query($dbconn, "delete from stok_trf_ln_temp where id='$id'");
	$sqla = pg_query($dbconn, "delete from stok_trf_batch_temp where id_ln ='$id'");

	//var_dump("delete from q_ln_temp where id='$id'");
?>