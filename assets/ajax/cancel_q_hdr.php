<?php 

$result=pg_query($dbconn,"DElete from q_ln_temp where id_user='".$_SESSION['id_users']."'");

?>