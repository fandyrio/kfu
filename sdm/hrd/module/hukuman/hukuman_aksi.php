<?php
include '../../koneksi.php';
$module=$_GET['module'];
$aksi=$_GET['aksi'];
$id = $_POST['id_hukuman'];
$hukuman = $_POST['nm_hukuman'];
$tgl = $_POST['tgl_hukuman'];
$nip = $_POST['nip'];
// HAPUS
if($module=='hukuman' AND $aksi=='hapus' ){ 
$mySql = "DELETE FROM hukuman WHERE id_hukuman='".$_GET['id_hukuman']."'";
$myQry = pg_query($mySql);
header('location:../../index.php?module='.$module);
}
// EDIT
else if($module=='hukuman' AND $aksi=='edit' ){ 
$query = pg_query("UPDATE hukuman SET
				  tgl_hukuman = '$tgl',
				  nm_hukuman = '$hukuman'
				  WHERE id_hukuman = '$id'");
header('location:../../index.php?module='.$module);
}
//Tambah
else if($module=='hukuman' AND $aksi=='tambah' ){ 
	header('location:../../index.php?module='.$module);
$sql = "INSERT INTO hukuman  (id_hukuman, nm_hukuman, tgl_hukuman, nip) VALUES ('$id', '$hukuman', '$tgl', '$nip')";
$simpan = pg_query($sql);
}
?>