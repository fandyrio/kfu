<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";

$idPasien=$_POST['idPasien'];
$idKunjungan=$_POST['idKunjungan'];
$noUrut=$_POST['noUrut'];
$namaObat=$_POST['namaObat'.$noUrut];
$idObat=$_POST['idObat'.$noUrut];
$ket=$_POST['keterangan'.$noUrut];
$dosis=$_POST['dosis'.$noUrut];
$satuan=$_POST['satuan'.$noUrut];
//$ah=$_POST['ah'.$id];




date_default_timezone_set("Indonesia/Jakarta");
$waktu=date('Y-m-d');

$checkMaxResep=pg_query("SELECT max(id_resep) as max from pasien_resep_order where id_kunjungan='$idKunjungan'");
$jumlahData=pg_num_rows($checkMaxResep);
$fetchMaxResep=pg_fetch_assoc($checkMaxResep);
/*if($fetchMaxResep['max']==null)
{*/
	$idResep=$_POST['idResep'];
/**/
/*else
{
	$idResepBefore=$fetchMaxResep['max'];
	$explodeR=explode("R", $idResepBefore);
	$nextIdResep=$explodeR[1]+1;
	$idResep="R".$nextIdResep;
}*/


$insertData=pg_query("INSERT INTO pasien_resep_order (id_pasien, status_proses, id_inv, id_kunjungan,nama_brand, dosis, waktu_input,ket, satuan,id_resep)
values ('$idPasien', 'N', '$idObat','$idKunjungan', '$namaObat','$dosis','$waktu','$ket','$satuan','$idResep')"); 

$idResep=pg_fetch_row($insertData);

if($insertData)
{
	echo $idResep[0];
}
else
{
	echo "Gagal Mengirimkan data".$id;
}

?>