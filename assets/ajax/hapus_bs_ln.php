<?php
	//var_dump($_GET['id']);

	$id=$_GET['id'];
	

	$sql = pg_query($dbconn, "delete from stok_buka_qty_temp where id='$id'");
	$sqla = pg_query($dbconn, "delete from stok_buka_batch_temp where id_stok_buka_qty_temp='$id'");

	//var_dump("delete from q_ln_temp where id='$id'");
?>