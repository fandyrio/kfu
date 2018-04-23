<?php
include "../../../config/conn.php";


$idKunjungan=$_POST['id_kunjungan'];

$deleteDataResepOrder=pg_query("DELETE from pasien_resep_order where id_kunjungan='$idKunjungan'");
$deleteDataResepKeterangan=pg_query("DELETE from pasien_resep_keterangan where id_kunjungan='$idKunjungan'");
$deleteDataNoResep=pg_query("DELETE from pasien_no_resep where id_kunjungan='$idKunjungan'");
?>