<?php
include "../config/fungsi_rupiah.php";
include "../config/fungsi_tanggal.php";

// Bagian Home
if ($_GET['module']=='home'){
	include "content/home/home.php";
}

elseif ($_GET['module']=='kegiatan'){
    include "content/kegiatan/kegiatan.php";
}

elseif ($_GET['module']=='urusan'){
    include "content/urusan/urusan.php";
}

elseif ($_GET['module']=='profile'){
    include "content/profile/profile.php";
}

elseif ($_GET['module']=='sistem'){
    include "content/sistem/sistem.php";
}

elseif ($_GET['module']=='organisasi'){
    include "content/organisasi/organisasi.php";
}

elseif ($_GET['module']=='sumberdana'){
    include "content/sumberdana/sumberdana.php";
}
elseif(isset($_GET['content']))
				{
					$modul = "data.php";
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					
					include "content/contentunit/".$_GET['content']."/".$modul;
					
				}
// Apabila modul tidak ditemukan
else{
	include "content/404.php";
	//header("location:keluar");
}

?>