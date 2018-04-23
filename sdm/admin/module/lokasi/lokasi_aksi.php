<?php
include "../../koneksi.php";

$module=$_GET['module'];
$aksi=$_GET['aksi'];

$id = $_POST['id_lokasi'];
$lokasi = $_POST['nm_lokasi'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
// HAPUS
if($module=='lokasi' AND $aksi=='hapus' ){ 
$mySql = "DELETE FROM lokasi_krj WHERE id_lokasi='".$_GET['id_lokasi']."'";
$myQry = pg_query($mySql);
header('location:../../index.php?module='.$module);
}

//Tambah
else if($module=='lokasi' AND $aksi=='tambah' ){ 
	
$sql = "INSERT INTO lokasi_krj  (id_lokasi, nm_lokasi, alamat_lokasi, no_hp) VALUES ('$id', '$lokasi', '$alamat', '$no_hp')";
$simpan = pg_query($sql);
header('location:../../index.php?module='.$module);
}
else if($module=='lokasi' AND $aksi=='edit' ){ 
pg_query("UPDATE lokasi_krj SET 
nm_lokasi='$lokasi',
no_hp='$no_hp',
alamat_lokasi='$alamat'
WHERE id_lokasi = '$id'");
header('location:../../index.php?module='.$module);
}
?>