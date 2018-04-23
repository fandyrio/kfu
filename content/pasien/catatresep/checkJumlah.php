<?php
include "../../../config/conn.php";
$idResep=$_POST['idResep'];
$idKunjungan=$_POST['idKunjungan'];
$idResep=$_POST['idResep'];

$checkDataPasien=pg_query("SELECT * from pasien_resep_order where id_kunjungan='$idKunjungan' and id_resep='$idResep'");
$jumlah=pg_num_rows($checkDataPasien);

echo $jumlah;
?>