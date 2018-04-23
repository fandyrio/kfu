<?php
include "include/koneksi.php";

if ($_GET['module'] == "home") {
	include "module/home.php";
}
else if ($_GET['module'] == "pangkat") {
	include "module/pangkat/pangkat.php";	
}
else if ($_GET['module'] == "unit_krj") {
	include "module/unit_krj/unit_krj.php";	
}
else if ($_GET['module'] == "user") {
	include "module/user/user.php";	
}
else if ($_GET['module'] == "jabatan") {
	include "module/jabatan/jabatan.php";	
}
else if ($_GET['module'] == "lokasi") {
	include "module/lokasi/lokasi.php";}
else if ($_GET['module'] == "edit_user") {
	include "module/edit_user.php";}
	
?>