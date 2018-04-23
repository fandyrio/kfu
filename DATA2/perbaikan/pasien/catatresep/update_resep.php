<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

 

           $id    = $_POST['id'];
           $dosis = $_POST['dosis'];     
            $diberi = $_POST['diberi'];    
           $jumlah_perhari = $_POST['jumlah_perhari'];
            $number_of_day = $_POST['number_of_day'];
         $instruksi1 = $_POST['instruksi1'];
         $instruksi2 = $_POST['instruksi2'];
         $indikasi = $_POST['indikasi'];
         $total_cost = $_POST['total_cost'];
         $total_cost =str_replace(".","",$total_cost);
        
         $total_sell = $_POST['total_sell'];
         $qty = $_POST['total'];
         $tanggal_awal=$_POST['tanggal_awal'];
         $tanggal_akhir=$_POST['tanggal_akhir'];
         



                       
            
    $res=pg_query($dbconn,"UPDATE  pasien_resep_order SET
      dosis='".$dosis."',
      jumlah_perhari= '".$jumlah_perhari."',  
      number_of_day = '".$number_of_day."', 
      instruksi1= '".$instruksi1."',
      instruksi2 = '".$instruksi2."',
      indikasi= '".$indikasi."',
      diberi= '".$diberi."',
      tgl_awal= '".$tanggal_awal."',
      tgl_akhir= '".$tanggal_akhir."',
      qty = '".$qty."'

      WHERE id='".$id."' "    
      );
    if($res){
      echo "success";

    }else{
       var_dump("UPDATE  pasien_resep_order SET
      dosis='".$dosis."',
      jumlah_perhari= '".$jumlah_perhari."',  
      number_of_day = '".$number_of_day."', 
      instruksi1= '".$instruksi1."',
      instruksi2 = '".$instruksi2."',
      indikasi= '".$indikasi."',
      diberi= '".$diberi."',
      tgl_awal= '".$tanggal_awal."',
      tgl_akhir= '".$tanggal_akhir."',
      qty = '".$qty."'

      WHERE id='".$id."' ");

    }

   


?>