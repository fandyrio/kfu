<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../config/conn.php";
session_start();
$id_unit=$_SESSION['id_units'];


$getPolyPerklinik=pg_query("select ppk.*, mp.id as poly_id, mp.code as code, mp.name as name from poly_perklinik ppk join master_poly mp on mp.id=ppk.id_poly where id_klinik='$id_unit'");

$checkData=pg_query("SELECT * from ruang_unit where id_unit='$id_unit'");
$jumlahData=pg_num_rows($checkData);

if($jumlahData==0)
{
	$data[]=$_GET['codePoly'];
	while($fetchPolyPerklinik=pg_fetch_assoc($getPolyPerklinik))
	{
		$jumlah=$data[0][$fetchPolyPerklinik['code']];
			var_dump($jumlah);
		
				$insertRoom=pg_query("INSERT into ruang_unit (id_unit, poly, jumlah) values ('$id_unit', '$fetchPolyPerklinik[poly_id]', '$jumlah')");
				echo "INSERT into ruang_unit (id_unit, poly, jumlah) values ('$id_unit', '$fetchPolyPerklinik[poly_id]', '$jumlah')";

	}
}
else
{
	$data[]=$_GET['codePoly'];
	while($fetchPolyPerklinik=pg_fetch_assoc($getPolyPerklinik))
	{
		$jumlah=$data[0][$fetchPolyPerklinik['code']];
		
				$insertRoom=pg_query("update ruang_unit set jumlah='$jumlah' where id_unit='$id_unit' and poly='$fetchPolyPerklinik[poly_id]'");
				echo "update ruang_unit set jumlah='$jumlah' where id_unit='$id_unit' and poly='$fetchPolyPerklinik[poly_id]'";

	}
}








?>