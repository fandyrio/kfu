<?php
include "../config/conn.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$noRM=$_GET['noRM'];
$getDataPasien=pg_query("SELECT * from master_pasien where no_rm='$noRM'");
$fetchDataPasien=pg_fetch_array($getDataPasien);
$jumlahPasien=pg_num_rows($getDataPasien);

echo $jumlahPasien;
?>