<?php
include "../../koneksi.php";

$module=$_GET['module'];
$aksi=$_GET['aksi'];

$id = $_POST['id_unit_krj'];
$unit_krj = $_POST['nm_unit_krj'];
// HAPUS
if($module=='unit_krj' AND $aksi=='hapus' ){ 
$mySql = "DELETE FROM unit_krj WHERE id_unit_krj='".$_GET['id_unit_krj']."'";
$myQry = pg_query($mySql);
header('location:../../index.php?module='.$module);
}
// EDIT
else if($module=='unit_krj' AND $aksi=='edit' ){ 
$query = pg_query("UPDATE unit_krj SET
				  nm_unit_krj = '$unit_krj'
				  WHERE id_unit_krj = '$id'");
header('location:../../index.php?module='.$module);
}
//Tambah
else if($module=='unit_krj' AND $aksi=='tambah' ){ 	
$sql = "INSERT INTO unit_krj  (id_unit_krj, nm_unit_krj) VALUES ('$id', '$unit_krj')";
$simpan = pg_query($sql);
header('location:../../index.php?module='.$module);
}
?>