<?php
include "include/koneksi.php";

if ($_GET['module'] == "home") {
	include "module/home.php";
}
else if ($_GET['module'] == "pegawai") {
	include "module/pegawai/pegawai.php";	
}
else if ($_GET['module'] == "prestasi") {
	include "module/prestasi/prestasi.php";	
}
else if ($_GET['module'] == "user") {
	include "module/edit_user.php";	
}
else if ($_GET['module'] == "sk_krj") {
	include "module/sk_krj/sk_krj.php";	
}
else if ($_GET['module'] == "hukuman") {
	include "module/hukuman/hukuman.php";	
}
else if ($_GET['module'] == "lokasi") {
	include "module/lokasi/lokasi.php";}
else if ($_GET['module'] == "edit_user") {
	include "module/edit_user.php";}
	
?>