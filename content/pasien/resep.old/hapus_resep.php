<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

$_SESSION["id_pasien"]= $_POST['id_pasien'];
$_SESSION["id_kunjungan"]= $_POST['id_kunjungan'];

$id=(int)$_POST['id'];
pg_query($dbconn,"DELETE FROM  pasien_resep WHERE id='".$id."' ");
pg_query($dbconn,"DELETE FROM  pasien_resep_batch WHERE id_pasien_resep='".$id."' ");
 pg_query($dbconn,"DELETE FROM inv_fiforeserve where  ke_id_ln='".$id."' and id_users='".$_SESSION['id_users']."' ");


?>