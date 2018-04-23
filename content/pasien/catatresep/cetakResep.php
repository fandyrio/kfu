<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";

$id_kunjungan=$_GET['id_kunjungan'];

echo $id_kunjungan;

?>