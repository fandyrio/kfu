<?php 

$result=pg_query($dbconn,"DElete from po_ln_temp where id_users='".$_SESSION['id_users']."'");

?>