<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";

$noUrut=$_POST['noResep'];

$statusRacikan=$_POST['status_racikan'];
if($statusRacikan=="NR")
{
	$sediaan=0;
	$sediaanDetail=	$_POST['idSediaanDetail'];
}
else
{
	$sediaan=$_POST['idSediaan'];
	$sediaanDetail=$_POST['sediaanDetailSelected'];
	
}
$iterasi=$_POST['iterasiLabel'];
$carapakai=$_POST['idCaraPakai'];
$XperH=$_POST['xh'];
$OperH=$_POST['oh'];
$jml=$_POST['jumlahObat'];
$ketSubs=$_POST['ketSubscription'];
$ketSigna=$_POST['ketSigna'];
$ah=$_POST['ah'];
$idKunjungan=$_POST['idKunjungan'];
/*$ketTambahan_2=$_POST['ketTambahan2_'.$noUrut];

$k5_1=$_POST['k5_1'.$noUrut];
$k6_1=$_POST['k6_1'.$noUrut];
$k7_1=$_POST['k7_1'.$noUrut];
$k8_1=$_POST['k8_1'.$noUrut];
//$idResep=$_POST['idResep'.$noUrut];
$ah=$_POST['ahKet'.$noUrut];

*/
echo $ah;

$checkMaxResep=pg_query("SELECT max(id_resep) as max from pasien_resep_keterangan where id_kunjungan='$idKunjungan'");
$jumlahData=pg_num_rows($checkMaxResep);
$fetchMaxResep=pg_fetch_assoc($checkMaxResep);
if($fetchMaxResep['max']==null)
{
	$idResep=$_POST['idResep'];
}
else
{
	$idResepBefore=$fetchMaxResep['max'];
	$explodeR=explode("R", $idResepBefore);
	$nextIdResep=$explodeR[1]+1;
	$idResep="R".$nextIdResep;
}

$insertData=pg_query("INSERT INTO pasien_resep_keterangan (sediaan,sediaan_detail,cara_pakai,xperh,operh,ket_subscription,ah,jml,ket_signa,id_kunjungan,id_resep,status_racikan,iterasi)
	values 
	('$sediaan', '$sediaanDetail', '$carapakai','$XperH','$OperH', '$ketSubs','$ah','$jml','$ketSigna','$idKunjungan','$idResep','$statusRacikan', '$iterasi')");
?>