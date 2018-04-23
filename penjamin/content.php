<?php
include "../config/library.php";
include "../config/fungsi_rupiah.php";
include "../config/fungsi_tanggal.php";


/*if ($_GET['module']=='home'){
    include "content/home/home.php";
}

elseif ($_GET['module']=='antrian'){
    include "content/antrian/antrian.php";
}

elseif ($_GET['module']=='jadwal'){
    include "content/mcu/jadwal/jadwal.php";
}

elseif ($_GET['module']=='penawaran'){
    include "content/mcu/penawaran/penawaran.php";
}*/
// Apabila modul tidak ditemukan
if(isset($_GET['penjamin']))
{
	$modul = "data.php";
	if(isset($_GET["modul"]))
	{
		$modul = $_GET["modul"].".php";
	}
	include "content/".$_GET['penjamin']."/".$modul;
}
else{
	include "content/404.php";
	//header("location:keluar");
}
?>