<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
          
    $id_pasien = $_POST['id_pasien'];
    $id_inv= $_POST['id_inv'];         
    $id_kunjungan = $_POST['id_kunjungan'];
    $qty= $_POST['qty'];
    
    $tampil=pg_query($dbconn,"select * from item_catalog where catalog_id='$id_inv'");
    $data=pg_fetch_array($tampil);
            
    $res=pg_query($dbconn,"INSERT INTO pasien_resep_order_detail ( id_inv,nama_brand, tgl_input, id_units, id_pasien, id_kunjungan) 
      VALUES(
      '$id_inv',  
      '$data[catalog_name]', 
      '".date('Y-m-d')."' ,
      '$_SESSION[id_units]',
      '$id_pasien',
      '$id_kunjungan'
      ) ");

    

    
     if($res){
      echo "success";
     }
     else{
       
     }
    


?>