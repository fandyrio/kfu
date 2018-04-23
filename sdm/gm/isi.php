<?php
include "include/koneksi.php";

if ($_GET['module'] == "home") {
	include "module/home.php";
}
else if ($_GET['module'] == "laporan") {
	include "module/laporan/laporan.php";	
}
else if ($_GET['module'] == "edit_user") {
	include "module/edit_user.php";	
}	
?>