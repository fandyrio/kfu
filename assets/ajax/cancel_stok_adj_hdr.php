<?php 

$hapus_adj_ln=pg_query($dbconn,"DELETE from stok_adj_ln where id_users='".$_SESSION['id_users']."'");
$hapus_adj_batch=pg_query($dbconn,"DELETE from stok_adj_batch where id_users='".$_SESSION['id_users']."'");
$sqla = pg_query($dbconn, "DELETE from inv_fiforeserve where id_users ='".$_SESSION['id_users']."'");

?>