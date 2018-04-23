<?php
include '../../koneksi.php';
$module=$_GET['module'];
$aksi=$_GET['aksi'];
$id = $_POST['id_prestasi'];
$prestasi = $_POST['nm_prestasi'];
$tgl = $_POST['tgl_prestasi'];
$nip = $_POST['nip'];
// HAPUS
if($module=='prestasi' AND $aksi=='hapus' ){ 
$mySql = "DELETE FROM prestasi WHERE id_prestasi='".$_GET['id_prestasi']."'";
$myQry = pg_query($mySql);
header('location:../../index.php?module='.$module);
}
// EDIT
else if($module=='prestasi' AND $aksi=='edit' ){ 
$query = pg_query("UPDATE prestasi SET				  
				  tgl_prestasi = '$tgl',
				  nm_prestasi = '$prestasi'
				  WHERE id_prestasi = '$id'");
header('location:../../index.php?module='.$module);
}
//Tambah
else if($module=='prestasi' AND $aksi=='tambah' ){ 
	header('location:../../index.php?module='.$module);
$sql = "INSERT INTO prestasi  (id_prestasi, nm_prestasi, tgl_prestasi, nip) VALUES ('$id', '$prestasi', '$tgl', '$nip')";
$simpan = pg_query($sql);
}
?>