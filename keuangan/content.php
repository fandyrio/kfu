<?php
include "../config/library.php";
include "../config/fungsi_rupiah.php";
include "../config/fungsi_tanggal.php";
include "config/myencrypt.php";
include "config/fungsi_umur.php";


if ($_GET['module']=='antrian'){
    include "content/antrian/antrian.php";
}

elseif ($_GET['module']=='jadwal'){
    include "content/jadwal/jadwal.php";
}

// Apabila modul tidak ditemukan
else{
	include "content/404.php";
	//header("location:keluar");
}
?>