<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";

$arr=$_POST['arrLab'];
$idKunjungan=$_POST['idKunjungan'];
$valueLab=$_POST['idLab'];
$dibuat_di=$_POST['kota_perujuk'];
$explodeValue=explode("_", $valueLab);
$idLab=$explodeValue[0];
$namaLab=$explodeValue[1];
$alamat_lab=$explodeValue[2];


$getDataPasien=pg_query("SELECT k.*, mp.public_id from kunjungan k join master_pasien mp on mp.id=k.id_pasien 
	where k.id='$idKunjungan'");
$fetchDataPasien=pg_fetch_assoc($getDataPasien);
$idPasien=$fetchDataPasien['public_id'];

$getReservasiLab=pg_query("SELECT * from reservasi_lab where id_kunjungan='$idKunjungan'");

$arrayExistedPemeriksaan=array();
while($fetchReservasiLab=pg_fetch_assoc($getReservasiLab))
{
	array_push($arrayExistedPemeriksaan, $fetchReservasiLab['id_pemeriksaan']);
}
$jumlahArrPemeriksaan=sizeof($arrayExistedPemeriksaan);
$jumlahArr=sizeof($arr);
for($a=1;$a<=$jumlahArrPemeriksaan;$a++)
{
	$b=$a-1;
	for($x=1;$x<=$jumlahArr;$x++)
	{
		$y=$x-1;
		$z=0;
		if($arrayExistedPemeriksaan[$b]==$arr[$y])
		{
			$z++;
		}
	}
	if($z==0)
	{
		$delete=pg_query("DELETE from reservasi_lab where id_pemeriksaan='$arrayExistedPemeriksaan[$b]' and id_kunjungan='$idKunjungan'");
	}
}



for($x=1;$x<=$jumlahArr;$x++)
{
	$y=$x-1;
	$explode=explode("_", $arr[$y]);
	$idPemeriksaan=$explode[1];
	$jenis_lab=$explode[0];
	$nama_pemeriksaan=$explode[2];

	if($jenis_lab=="single")
	{
		$checkData=pg_query("SELECT count(id_pemeriksaan) as jumlah from reservasi_lab where id_pemeriksaan='$idPemeriksaan' and id_kunjungan='$idKunjungan' and jenis_lab='single'");
		$fetchData=pg_fetch_assoc($checkData);
		$jumlah=$fetchData['jumlah'];
	}
	else
	{
		$checkData=pg_query("SELECT count(id_pemeriksaan) as jumlah from reservasi_lab where id_pemeriksaan='$idPemeriksaan' and id_kunjungan='$idKunjungan' and jenis_lab='multi'");
		$fetchData=pg_fetch_assoc($checkData);
		$jumlah=$fetchData['jumlah'];
		
	}
		if($jumlah==0)
		{
			$insert=pg_query("INSERT INTO reservasi_lab (public_id,id_pemeriksaan,jenis_lab,id_kunjungan,kode_lab,id_lab,nama_pemeriksaan)
				values ('$idPasien', '$idPemeriksaan', '$jenis_lab', '$idKunjungan', '1', '$idLab', '$nama_pemeriksaan')
				");
		}


}

$update1=pg_query("UPDATE data_reservasi_lab set lab='$namaLab', id_lab='$idLab', alamat_lab='$alamat_lab', dibuat_di='$dibuat_di' where id_kunjungan='$idKunjungan'");
$update2=pg_query("UPDATE reservasi_lab set id_lab='$idLab' where id_kunjungan='$idKunjungan'")




?>