<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../config/conn.php";

$idUnit=$_SESSION['id_units'];
$getOutlet=pg_query("SELECT * from master_unit where id='$idUnit'");
$fetchOutlet=pg_fetch_assoc($getOutlet);
$outletId=$fetchOutlet['id_outlet'];

$namaSync=$_POST['name'];

$update=pg_query("UPDATE list_sync set last_update='now()' where nama_sync='$namaSync' and outlet_id='$outletId'");


?>