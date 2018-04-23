<?php
if ($_GET['module']=='home'){
	echo"Dashboard";
}

elseif ($_GET['module']=='keluhan'){
    echo"Keluhan";
}

elseif ($_GET['module']=='departemen'){
    echo"Departemen";
}

elseif ($_GET['module']=='kategori'){
    echo"Kategori";
}

elseif ($_GET['module']=='pegawai'){
    echo"Pegawai";
}

elseif ($_GET['module']=='halaman'){
    echo"Halaman Lainnya";
}

elseif ($_GET['module']=='rekap1'){
    echo"Rekapitulasi Keluhan Berdasarkan Kategori";
}

elseif ($_GET['module']=='rekap2'){
    echo"Rekapitulasi Keluhan Berdasarkan Pegawai";
}

elseif ($_GET['module']=='rekap3'){
    echo"Rekapitulasi Keluhan Selesai";
}

elseif ($_GET['module']=='rekap4'){
    echo"Rekapitulasi Keluhan Proses";
}

elseif ($_GET['module']=='rekap5'){
    echo"Rekapitulasi Keluhan Pending";
}

elseif ($_GET['module']=='pengaturan'){
    echo"Pengaturan";
}
?>