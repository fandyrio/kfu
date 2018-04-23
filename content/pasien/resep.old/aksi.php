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

           $tampil=pg_query($dbconn,"select i.*, n.nama from inv_inventori i 
            inner join inv_nama_brand n on n.id=i.id_brand and i.id='".$id_inv."'");
           $data=pg_fetch_array($tampil);


                       
            
    $res=pg_query($dbconn,"INSERT INTO pasien_resep (id_pasien, id_inv,nama_brand, id_kunjungan, id_kategori_layanan, id_departemen, waktu_input, id_unit) 
      VALUES(
      '".$id_pasien."',
      '".$id_inv."',  
      '".$data["nama"]."', 
      '".$id_kunjungan."',
      '".$id_kategori_layanan."',
      '".$id_departemen."',
      '".date('Y-m-d')."' ,
      '".$_SESSION['id_units']."'  
      ) RETURNING id");

     $row = pg_fetch_row($res);
     if($res){
      echo "success";
         $_SESSION["id_resep"]=$row[0];
         $_SESSION["id_pasien"]=$id_pasien;
         $_SESSION["id_kunjungan"]=$id_kunjungan;
     }
     else{
        var_dump("INSERT INTO pasien_resep (id_pasien, id_inv,nama_brand, id_kunjungan, id_kategori_layanan, id_departemen, waktu_input, id_unit) 
      VALUES(
      '".$id_pasien."',
      '".$id_inv."',  
      '".$data["nama"]."', 
      '".$id_kunjungan."',
      '".$id_kategori_layanan."',
      '".$id_departemen."',
      '".date('Y-m-d')."' ,
      '".$_SESSION['id_units']."'  
      ) RETURNING id");
     }
    


?>