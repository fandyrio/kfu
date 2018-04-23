<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";


           $id    = $_POST['id'];

           $result=pg_query($dbconn,"INSERT INTO pasien_resep ( id_pasien, id_kunjungan, status_proses, id_inv, id_kategori_layanan,   id_departemen, nama_brand, dosis, jumlah_perhari, number_of_day, instruksi1, instruksi2, indikasi, id_unit, 
            qty,total_cost, waktu_input
          )
            SELECT id_pasien, id_kunjungan, 'N', id_inv, id_kategori_layanan,
            id_departemen, nama_brand, dosis, jumlah_perhari, number_of_day, instruksi1, instruksi2, indikasi, id_unit, 
            qty,total_cost, '".date('Y-m-d')."'  FROM pasien_resep_order    WHERE id = '$id' RETURNING id");

                       
            


     $result = pg_fetch_row($res);
     if($result){
      echo "success";
         $_SESSION["id_resep"]=$row[0];
         $_SESSION["id_pasien"]=$id_pasien;
         $_SESSION["id_kunjungan"]=$id_kunjungan;
     }
     else{
        var_dump("INSERT INTO pasien_resep ( id_pasien, id_kunjungan, status_proses, id_inv, id_kategori_layanan,   id_departemen, nama_brand, dosis, jumlah_perhari, number_of_day, instruksi1, instruksi2, indikasi, id_unit, 
            qty,total_cost
          )
            SELECT id_pasien, id_kunjungan, 'N', id_inv, id_kategori_layanan,
            id_departemen, nama_brand, dosis, jumlah_perhari, number_of_day, instruksi1, instruksi2, indikasi, id_unit, 
            qty,total_cost  FROM pasien_resep_order    WHERE id = '$id' RETURNING id");
     }
    


?>