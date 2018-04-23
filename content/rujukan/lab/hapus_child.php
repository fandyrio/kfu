<?php
$id = $_POST["id"];
$res=pg_query($dbconn,"DELETE FROM pasien_rujukan_detail WHERE id = '".$id."'");



?>