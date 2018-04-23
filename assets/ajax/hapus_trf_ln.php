<?php
	//var_dump($_GET['id']);

	$id=$_POST['id'];
	

	$sql = pg_query($dbconn, "delete from stok_trf_ln where id='$id'");
	$sqla = pg_query($dbconn, "delete from stok_trf_batch where id_ln ='$id'");
	$sqla = pg_query($dbconn, "delete from inv_fiforeserve where ke_id_ln ='$id'");

	//var_dump("delete from q_ln_temp where id='$id'");
?>