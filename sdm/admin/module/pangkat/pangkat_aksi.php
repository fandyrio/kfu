<?php
include "../../koneksi.php";

$module=$_GET['module'];
$aksi=$_GET['aksi'];

$id = $_POST['id_pangkat'];
$pangkat = $_POST['nm_pangkat'];
$gaji = $_POST['gaji'];
// HAPUS
if($module=='pangkat' AND $aksi=='hapus' ){ 
$mySql = "DELETE FROM pangkat WHERE id_pangkat='".$_GET['id_pangkat']."'";
$myQry = pg_query($mySql);
header('location:../../index.php?module='.$module);
}
else if($module=='pangkat' AND $aksi=='edit' ){ 
$sql = "UPDATE pangkat SET 
nm_pangkat='$pangkat',
gaji='$gaji'
WHERE id_pangkat = '$id'";
$edit = pg_query($sql);
header('location:../../index.php?module='.$module);
}
//Tambah
else if($module=='pangkat' AND $aksi=='tambah' ){ 
	header('location:../../index.php?module='.$module);
$sql = "INSERT INTO pangkat  (id_pangkat, nm_pangkat, gaji) VALUES ('$id', '$pangkat', '$gaji')";
$simpan = pg_query($sql);
}

?>