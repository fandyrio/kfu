<?php
include "../../../config/conn.php";

$idImage=$_POST['id'];

$deleteQuery=pg_query("DELETE from pasien_image_pemeriksaan where id='$idImage'");

?>