<?php
include "../config/library.php";
include "../config/fungsi_rupiah.php";
include "../config/fungsi_tanggal.php";


if ($_GET['module']=='home'){
    include "content/home/home.php";
}

elseif ($_GET['module']=='activity_type'){
    include "content/activity_type/activity_type.php";
}

elseif ($_GET['module']=='crm_status'){
    include "content/crm_status/crm_status.php";
}

elseif ($_GET['module']=='laporan'){
    include "content/laporan/laporan.php";
}

elseif ($_GET['module']=='transaksi_prospek'){
    include "content/transaksi_prospek/transaksi_prospek.php";
}

elseif ($_GET['module']=='transaksi_target'){
    include "content/transaksi_target/transaksi_target.php";
}

/*
elseif ($_GET['module']=='target_realisasi'){
    include "content/target_realisasi/target_realisasi.php";
}
*/

elseif ($_GET['module']=='mcu_perusahaan'){
    include "content/mcu/perusahaan/mcu_perusahaan.php";
}

elseif ($_GET['module']=='mcu_penawaran'){
    include "content/mcu/penawaran/data.php";
}

elseif ($_GET['module']=='mcu_jadwal'){
    include "content/mcu/jadwal/data.php";
}

/*
elseif ($_GET['module']=='billing'){
    include "content/billing/billing.php";
}

elseif ($_GET['module']=='billing_klaim'){
    include "content/billing/billing_klaim.php";
}

elseif ($_GET['module']=='billing_invoice'){
    include "content/billing/billing_invoice.php";
}

elseif ($_GET['module']=='billing_pembayaran'){
    include "content/billing/billing_pembayaran.php";
}
*/

elseif(isset($_GET['content']))   {
    $modul = "data.php";
    if(isset($_GET["modul"]))
     {
      $modul = $_GET["modul"].".php";
    }
                    
  include "content/".$_GET['content']."/penawaran/".$modul;
                    
}
elseif(isset($_GET['jadwal']))   {
    $modul = "data.php";
    if(isset($_GET["modul"]))
     {
      $modul = $_GET["modul"].".php";
    }
                    
  include "content/".$_GET['jadwal']."/jadwal/".$modul;
                    
}

// Apabila modul tidak ditemukan
else{
	include "content/404.php";
	//header("location:keluar");
}
?>