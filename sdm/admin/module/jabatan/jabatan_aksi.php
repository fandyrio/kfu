<?php
include "../../koneksi.php";

$module=$_GET['module'];
$aksi=$_GET['aksi'];

$id = $_POST['id_jabatan'];
$jabatan = $_POST['nm_jabatan'];
// HAPUS
if($module=='jabatan' AND $aksi=='hapus' ){ 
$mySql = "DELETE FROM jabatan WHERE id_jabatan='".$_GET['id_jabatan']."'";
$myQry = pg_query($mySql);
header('location:../../index.php?module='.$module);
}
// EDIT
else if($module=='jabatan' AND $aksi=='edit' ){ 
$query = pg_query("UPDATE jabatan SET
				  nm_jabatan = '$jabatan'
				  WHERE id_jabatan = '$id'");
header('location:../../index.php?module='.$module);
}
//Tambah
else if($module=='jabatan' AND $aksi=='tambah' ){ 
	header('location:../../index.php?module='.$module);
$sql = "INSERT INTO jabatan  (id_jabatan, nm_jabatan) VALUES ('$id', '$jabatan')";
$simpan = pg_query($sql);
}
else if($module=='jabatan' AND $aksi=='edit' ){ 
 
	header('location:../../index.php?module='.$module);
	}
?>