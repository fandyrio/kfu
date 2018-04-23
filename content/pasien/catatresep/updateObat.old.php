<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include "../../../config/conn.php";


$idPasien=$_POST['idPasien'];
$idKunjungan=$_POST['idKunjungan'];
$id=$_POST['id'];
$idObatResep=$_POST['idObatResep'.$id];
$namaObat=$_POST['namaObat'.$id];
$idObat=$_POST['idObat'.$id];
$ap=$_POST['ap'.$id];
$dosis=$_POST['dosis'.$id];
$satuan=$_POST['satuan'.$id];

date_default_timezone_set("Indonesia/Jakarta");
$waktu=date('Y-m-d');

if($id==0)
{
	$ah=$_POST['ah'.$id];
	$jml=$_POST['jml'.$id];
}
else
{
	$ah=null;
	$jml=null;
}


/*$insertData=pg_query("INSERT INTO pasien_resep_order (id_pasien, status_proses, id_inv, qty, id_kunjungan,nama_brand, dosis, waktu_input,ap, satuan) 
	values ('$idPasien', 'N', '$idObat', '$jml', '$idKunjungan', '$namaObat','$dosis','$waktu','$ap','$satuan')");*/
$updateData=pg_query("UPDATE pasien_resep_order set id_inv='$idObat', qty='$jml', nama_brand='$namaObat', dosis='$dosis', ap='$ap', satuan='$satuan', 
	ah='$ah'
	where id_pasien='$idPasien' and id_kunjungan='$idKunjungan' and status_proses='N' and id='$idObatResep'");

if($updateData)
{
	echo $idObatResep;
}
else
{

}

?>