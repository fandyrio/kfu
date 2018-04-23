<?php 

$hapus_grn_ln=pg_query($dbconn,"DELETE from grn_ln_temp where id_users='".$_SESSION['id_users']."'");
$hapus_grn_batch=pg_query($dbconn,"DELETE from grn_batch_temp where id_users='".$_SESSION['id_users']."'");

?>