<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";

$id_kunjungan=$_POST['id_kunjungan'];
$id_pasien=$_POST['id_pasien'];
$id_unit=$_SESSION['id_units'];
$statusCito=$_POST['statusCito'];

$getKodeOutlet=pg_query("SELECT * from master_unit where id='$id_unit'");
$fetchKodeOutlet=pg_fetch_assoc($getKodeOutlet);

$check=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$id_kunjungan'");
$jumlahCheck=pg_num_rows($check);
if($jumlahCheck==0)
{
	echo "0";
}
else
{
	$getMax=pg_query("SELECT max(id) as maxId from pasien_no_resep");
    $fetchMax=pg_fetch_assoc($getMax);
    $public_id=$fetchMax['maxid']+=1;
    $sprintF=sprintf("%06d", $public_id);
    $unikUnit=sprintf("%03d", $_SESSION['id_units']);
    $public_idResep="R".$unikUnit.'0'.$sprintF;

    $noResep=$fetchKodeOutlet['kode'].' / '.date('Y').date('m').' / '.$sprintF;

    $insert=pg_query("INSERT into pasien_no_resep (id_kunjungan, public_id, no_resep,id_pasien,cito) values ('$id_kunjungan', '$public_idResep', '$noResep', '$id_pasien','$statusCito')");
}
?>