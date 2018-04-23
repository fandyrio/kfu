<?php 

$hapus_trf_ln=pg_query($dbconn,"DELETE from stok_trf_ln where id_users='".$_SESSION['id_users']."'");
$hapus_trf_batch=pg_query($dbconn,"DELETE from stok_trf_batch where id_users='".$_SESSION['id_users']."'");
$sqla = pg_query($dbconn, "DELETE from inv_fiforeserve where id_users ='".$_SESSION['id_users']."'");

?>