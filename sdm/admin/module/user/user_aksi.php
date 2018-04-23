<?php
include "../../koneksi.php";

$module=$_GET['module'];
$aksi=$_GET['aksi'];

$id = $_POST['id_user'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$nama = $_POST['nama'];
$no_hp = $_POST['no_hp'];
$level = $_POST['level'];

// HAPUS
if($module=='user' AND $aksi=='no' ){ 
$sql = "UPDATE users SET blokir='N' WHERE id_user = '".$_GET['id_user']."'";
$hapus = pg_query($sql);
header('location:../../index.php?module='.$module);
}
// EDIT
else if($module=='user' AND $aksi=='yes' ){ 
$sql = "UPDATE users SET blokir='Y' WHERE id_user = '".$_GET['id_user']."'";
$hapus = pg_query($sql);
header('location:../../index.php?module='.$module);
}
//Tambah
else if($module=='user' AND $aksi=='tambah' ){ 
	header('location:../../index.php?module='.$module);
$sql = "INSERT INTO users  (id_user, username, pass, nama, no_hp, level ) VALUES ('$id', '$user', '$pass', '$nama', '$no_hp', '$level')";
$simpan = pg_query($sql);
}

?>