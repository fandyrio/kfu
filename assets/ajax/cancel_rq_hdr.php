<?php 

$result=pg_query($dbconn,"DElete from rq_ln_temp where id_users='".$_SESSION['id_users']."'");

?>