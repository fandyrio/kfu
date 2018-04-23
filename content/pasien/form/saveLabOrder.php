<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include "../../../config/conn.php";

$arr=$_POST['arrLab'];
$idKunjungan=$_POST['idKunjungan'];
$dibuat_di=$_POST['kota_perujuk'];
$valueLab=$_POST['idLab'];
$explodeValue=explode("_", $valueLab);
$idLab=$explodeValue[0];
$namaLab=$explodeValue[1];
$alamatLab=$explodeValue[2];

$getDataPasien=pg_query("SELECT k.*, mp.public_id from kunjungan k join master_pasien mp on mp.id=k.id_pasien 
	where k.id='$idKunjungan'");
$fetchDataPasien=pg_fetch_assoc($getDataPasien);
$idPasien=$fetchDataPasien['public_id'];

$jumlahArr=sizeof($arr);


for($x=1;$x<=$jumlahArr;$x++)
{
	$y=$x-1;
	$explode=explode("_",$arr[$y]);
	$jenis_lab=$explode[0];
	$id_pemeriksaan=$explode[1];
	$nama_pemeriksaan=$explode[2];
	echo $jenis_lab;
	$insertOrderLab=pg_query("INSERT INTO reservasi_lab (public_id,id_pemeriksaan,jenis_lab,id_kunjungan,kode_lab,id_lab, nama_pemeriksaan)
		values('$idPasien','$id_pemeriksaan', '$jenis_lab', '$idKunjungan', '1','$idLab', '$nama_pemeriksaan')
		");
}

$insertData=pg_query("INSERT INTO data_reservasi_lab (public_id, id_kunjungan, tanggal,lab,id_lab,alamat_lab,dibuat_di) values ('$idPasien', '$idKunjungan',now(), '$namaLab', '$idLab','$alamatLab', '$dibuat_di') RETURNING id_pemeriksaan");
$row=pg_fetch_row($insertData);


$idPemeriksaan=$row[0];

//=========================================
//GENERATE NO SURAT
//=========================================
$thisMonth=date('m');
$thisYear=date('Y');
$noUrut=sprintf('%05d',$idPemeriksaan);
$noSurat=$noUrut.' / '. $thisMonth. ' / '.$thisYear;

$updateData=pg_query("UPDATE data_reservasi_lab set no_surat='$noSurat' where id_pemeriksaan='$idPemeriksaan'");
//==========================================
?>