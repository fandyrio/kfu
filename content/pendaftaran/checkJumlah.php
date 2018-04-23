<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include "../../config/conn.php";

$noBPJS=$_GET['noBPJS'];
$thisYear=date("Y");

$bpjsData=pg_query("SELECT count(*) as jumlah from log_bpjs lb join master_pasien mp on mp.no_bpjs=lb.no_bpjs
	where lb.no_bpjs='$noBPJS' and extract(year from lb.tanggal::timestamp)='$thisYear'");
$fetchBPJS=pg_fetch_assoc($bpjsData);
$jumlahTahunIni=$fetchBPJS['jumlah'];

$checkData=pg_query("SELECT count(*) as jumlah from log_bpjs lb join master_pasien mp on mp.no_bpjs=lb.no_bpjs
	where lb.no_bpjs='$noBPJS'");
$fetchData=pg_fetch_assoc($checkData);
$jumlahPasien=$fetchData['jumlah'];

$getExisted=pg_query("SELECT count(*) as jumlah from master_pasien where no_bpjs='$noBPJS'");
$fetchExisted=pg_fetch_assoc($getExisted);
$jumlahExisted=$fetchExisted['jumlah'];

if($jumlahExisted!=0)
{
	$getDataPasien=pg_query("SELECT * from master_pasien where no_bpjs='$noBPJS'");
	$fetchDataPasien=pg_fetch_assoc($getDataPasien);
	$no_rm=$fetchDataPasien['no_rm'];
}
/*
if($jumlahPasien!=0)
{
	$getDataPasien=pg_query("SELECT * from master_pasien where no_bpjs='$noBPJS'");
	$fetchDataPasien=pg_fetch_assoc($getDataPasien);
	$no_rm=$fetchDataPasien['no_rm'];
}*/
else
{
	$no_rm="0";
}


$return = array('jumlah'=>$jumlahTahunIni, 'no_rm'=>$no_rm, 'jumlahPasien' => $jumlahPasien, 'jumlahExisted'=>$jumlahExisted);
$data=json_encode($return);

echo $data;
?>