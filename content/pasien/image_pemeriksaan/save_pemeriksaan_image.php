<?php
ini_set('date.timezone','Asia/Jakarta');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";
$uploadTo='images/';
if (!empty($_FILES["file"]["tmp_name"]))
{
    $jenis_gambar=$_FILES['file']['type'];
    $typeData=explode("/",$jenis_gambar);
    $type=$typeData[1];
    $namaFile=$_POST['nama_pemeriksaan'].'-'.date('hms').$_POST['id_pasien'].'.'.$type;
    $tgl_sekarang=date('Y-m-d');
    if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/x-png" || $jenis_gambar=="image/png")
    {           
        $gambar = $uploadTo . basename($namaFile);       
        if (move_uploaded_file($_FILES['file']['tmp_name'], $gambar)) {
        	$insert=pg_query("INSERT into pasien_image_pemeriksaan (nama,tanggal,file,id_pasien,id_kunjungan) values 
        		('$_POST[nama_pemeriksaan]', '$tgl_sekarang','$namaFile','$_POST[id_pasien]', '0')");
            echo "Gambar berhasil dikirim ";
        } else {
           echo "Gambar gagal dikirim";
        }
    } 
    else 
    {
        echo "Jenis gambar yang anda kirim salah. Harus .jpg .gif .png";
   	}
} else {
    echo "Anda belum memilih gambar";
}


?>