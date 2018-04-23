<?php
include "../../../config/conn.php";

$idKunjungan=$_POST['idKunjungan'];

$deleteDataLabOrder=pg_query("DELETE from data_reservasi_lab where id_kunjungan='$idKunjungan'");
$deleteOrderDetail=pg_query("DELETE FROM reservasi_lab where id_kunjungan='$idKunjungan'");
?>