<?php
include '../../koneksi.php';
$module=$_GET['module'];
$aksi=$_GET['aksi'];
$no_sk = $_POST['no_sk'];
$no_sk_lm = $_POST['no_sk_lm'];
$nip = $_POST['nip'];
$tgl_sk = $_POST['tgl_sk'];
$id_pangkat = $_POST['pangkat'];
$id_lokasi = $_POST['lokasi'];
$id_jabatan = $_POST['jabatan'];
$id_unit_krj = $_POST['unit_krj'];

// HAPUS
if($module=='sk_krj' AND $aksi=='hapus' ){ 
$mySql = "DELETE FROM sk_krj WHERE no_sk='".$_GET['no_sk']."'";
$myQry = pg_query($mySql);
header('location:../../index.php?module='.$module);
}
//edit
else if($module=='sk_krj' AND $aksi=='edit' ){ 
$query1 = pg_query("UPDATE sk_krj SET				 				  				  				  
				  status_sk = 'nonaktif'				  
				  WHERE no_sk = '$no_sk_lm'");	
$simpa = pg_query("INSERT INTO sk_krj  (no_sk, tgl_sk, nip, id_jabatan, id_lokasi, id_pangkat, id_unit_krj, status_sk) VALUES ( '{$no_sk}','{$tgl_sk}','{$nip}','{$id_jabatan}', '{$id_lokasi}','{$id_pangkat}','{$id_unit_krj}','aktif')");
				  
header('location:../../index.php?module='.$module);
}
?>