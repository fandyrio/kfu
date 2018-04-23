<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
           $id_pasien    = $_POST['id_pasien'];
           $id_inv       = $_POST['id_inv'];

         
           $id_kunjungan = $_POST['id_kunjungan'];
           $id_departemen    = $_POST['id_departemen'];
           $id_kategori_layanan    = $_POST['id_layanan'];

           $tampil=pg_query($dbconn,"select * from item_catalog where catalog_id='$id_inv'");
           $data=pg_fetch_array($tampil);
            
    $res=pg_query($dbconn,"INSERT INTO pasien_resep_order (id_pasien, id_inv,nama_brand, id_kunjungan, id_kategori_layanan,  waktu_input, id_unit, status_racik) 
      VALUES(
      '".$id_pasien."',
      '".$id_inv."',  
      '$data[catalog_name]', 
      '".$id_kunjungan."',
      '".$id_kategori_layanan."',
      '".date('Y-m-d')."' ,
      '".$_SESSION['id_units']."',
      'N' 
      ) RETURNING id");

    var_dump("INSERT INTO pasien_resep_order (id_pasien, id_inv,nama_brand, id_kunjungan, id_kategori_layanan,  waktu_input, id_unit, status_racik) 
      VALUES(
      '".$id_pasien."',
      '".$id_inv."',  
      '$data[catalog_name]', 
      '".$id_kunjungan."',
      '".$id_kategori_layanan."',
      '".date('Y-m-d')."' ,
      '".$_SESSION['id_units']."',
      'N' 
      ) RETURNING id");

     $row = pg_fetch_row($res);
     if($res){
      echo "success";
      
     }
     else{
       
     }
    


?>