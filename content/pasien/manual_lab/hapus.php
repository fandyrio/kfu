<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
$query=pg_query($dbconn,"DELETE FROM pasien_manual_lab where id='$_POST[id]'");

if($query){
	echo "success";
}
else{
	echo "gagal";
}

?>
