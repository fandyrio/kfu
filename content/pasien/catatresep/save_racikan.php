<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

    $id_pasien    = $_POST['id_pasien'];
    $id_kunjungan = $_POST['id_kunjungan'];
    $id_kategori_layanan    = $_POST['id_kategori_harga'];

    $res=pg_query($dbconn,"INSERT INTO pasien_resep_order (id_pasien, nama_brand, id_kunjungan, id_kategori_layanan,  waktu_input, id_unit, status_racik, kode_barang) 
      VALUES(
      '$id_pasien',  
      '$_POST[nama_barang]', 
      '$id_kunjungan',
      '$id_kategori_layanan',
      '".date('Y-m-d')."' ,
      '$_SESSION[id_units]',
      'Y',
      '$_POST[kode_barang]' 
      ) RETURNING id");

     $row = pg_fetch_row($res);

   
    $tampil=pg_query($dbconn,"select i.* from pasien_resep_order_detail i where i.id_pasien='$id_pasien' AND i.id_kunjungan='$id_kunjungan' ");

    

    while($r=pg_fetch_array($tampil)){

      $id_d= $r[id];
      $qty=$_POST["qty#$id_d"];

      pg_query($dbconn,"UPDATE pasien_resep_order_detail set qty='$qty', id_pasien_resep_order ='$row[0]' where id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' and id='$r[id]' ");

    }
    
    if($res){
      echo "success";
        
     }
     else{
       
     }
    


?>