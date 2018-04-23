<?php
include "config/library.php";
include "config/fungsi_rupiah.php";
include "config/fungsi_tanggal.php";
include "config/myencrypt.php";
include "config/fungsi_umur.php";



// dinamis gateaway
if(isset($_GET['klien']))
{
        include "config/conn.php";
        $fitur = "data.php";
        if(isset($_GET["fitur"]))
        {
            $fitur = $_GET["fitur"].".php";
        }
            include "content/".$_GET['klien']."/".$fitur;
                    
}

if ($_GET['module']=='pendaftaran'){
	include "content/pendaftaran/pendaftaran.php";
}
elseif ($_GET['module']=='perusahaan'){
    include "content/perusahaan/data.php";
}
elseif(isset($_GET['content']))
                {
                    $modul = "data.php";
                    if(isset($_GET["modul"]))
                    {
                        $modul = $_GET["modul"].".php";
                    }
                    
                    include "content/".$_GET['content']."/".$modul;
                    
}


elseif ($_GET['module']=='antrian'){
    include "content/antrian/antrian.php";
}



elseif ($_GET['module']=='jadwal'){
    include "content/jadwal/jadwal.php";
}

elseif ($_GET['module']=='pasien'){
    include "content/pasien/pasien.php";
}
elseif ($_GET['module']=='resep_pasien'){
   include "content/pasien/resep/resep_pasien.php";
}
elseif ($_GET['module']=='rawatinap'){
    include "content/rawatinap/rawatinap.php";
}

elseif ($_GET['module']=='applicare'){
    include "content/applicare/applicare.php";
}

elseif ($_GET['module']=='home'){
    include "content/home/home.php";
}

elseif ($_GET['module']=='alat_bantu'){
    include "content/alat_bantu/alat_bantu.php";
}

elseif ($_GET['module']=='keuangan_customer_billing'){
    include "content/keuangan/customer/billing/billing.php";
}

elseif ($_GET['module']=='keuangan_customer_invoice'){
    include "content/keuangan/customer/invoice/invoice.php";
}

elseif ($_GET['module']=='keuangan_customer_payment'){
    include "content/keuangan/customer/payment/payment.php";
}

elseif ($_GET['module']=='keuangan_customer_klaim'){
    include "content/keuangan/customer/klaim/klaim.php";
}

elseif ($_GET['module']=='labhasil'){
    include "content/lab_tracking/labhasil.php";
}
elseif ($_GET['module']=='laborder'){
    include "content/lab_tracking/laborder.php";
}
elseif ($_GET['module']=='jenis_pemeriksaan'){
    include "content/report/jenis_pemeriksaan.php";
}

elseif ($_GET['module']=='laporan_data_pasien'){
    include "content/report/laporan_data_pasien.php";
}

elseif ($_GET['module']=='laporan_pasien'){
    include "content/report/laporan_data_pasien.php";
}

elseif ($_GET['module']=='laporan_rawat_jalan'){
    include "content/report/laporan_kunjungan.php";
}

elseif ($_GET['module']=='laporan_fee_dokter'){
    include "content/report/laporan_fee_dokter.php";
}

elseif ($_GET['module']=='laporan_prb'){
    include "content/report/laporan_prb.php";
}
elseif ($_GET['module']=='settings_klinik'){
    include "content/settings/setting_klinik.php";
}

elseif ($_GET['module']=='import'){
    include "content/import/import.php";
}
elseif ($_GET['module']=='analisis_kunjungan'){
    include "content/analisis/analisis_kunjungan.php";
}
elseif ($_GET['module']=='analisis_pasien'){
    include "content/analisis/analisis_pasien.php";
}

elseif ($_GET['module']=='import_data'){
   include "content/import/aksi_import.php";
}
elseif ($_GET['module']=='panggil_antrian'){
   include "queue/client/index.php";
}
elseif ($_GET['module']=='rujukan_laboratorium'){
    include "content/rujukan/lab/rujukan_laboratorium.php";
}
elseif ($_GET['module']=='rujukan_diterima'){
    include "content/rujukan/rujukan_diterima.php";
}
elseif ($_GET['module']=='kesimpulan_saran'){
    include "content/pasien/kesimpulan_saran/kesimpulan.php";
}
elseif ($_GET['module']=='form'){
    include "content/form/form.php";
}

elseif ($_GET['inventori']){
    include ('config/function.php');
   
     $modul = "data.php";
    
        if(isset($_GET["modul"]))
        {
            $modul = $_GET["modul"].".php";
        }
    include "content/".$_GET['inventori']."/".$modul;
}
elseif ($_GET['module']=='getAllReservasi'){
    include "data/api_getAllReservasi.php";
}



// Apabila modul tidak ditemukan
else{
	include "content/404.php";
	//header("location:keluar");
}
?>