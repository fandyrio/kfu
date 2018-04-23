<?php 

$hapus_trf_ln=pg_query($dbconn,"DELETE from stok_trf_ln_temp where id_users='".$_SESSION['id_users']."'");
$hapus_trf_batch=pg_query($dbconn,"DELETE from Stok_trf_batch_temp where id_users='".$_SESSION['id_users']."'");

?>