<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

 
var_dump($_POST);
           $id    = $_POST['id'];
           $dosis = $_POST['dosis'];         
           $jumlah_perhari = $_POST['jumlah_perhari'];
          $number_of_day = $_POST['number_of_day'];
         $instruksi1 = $_POST['instruksi1'];
         $instruksi2 = $_POST['instruksi2'];
         $indikasi = $_POST['indikasi'];
         $total_cost = $_POST['total_cost'];
         $total_cost =str_replace(".","",$total_cost);
        
         $total_sell = $_POST['total_sell'];
         



                       
            
    $res=pg_query($dbconn,"UPDATE  pasien_resep SET
      dosis='".$dosis."',
      jumlah_perhari= '".$jumlah_perhari."',  
      number_of_day = '".$number_of_day."', 
      instruksi1= '".$instruksi1."',
      instruksi2 = '".$instruksi2."',
      indikasi= '".$indikasi."',
      total_cost = '".$total_cost."',      
      total_sell = '".$total_sell."'

      WHERE id='".$id."' "    
      );
    if($res){
      echo "success";

    }else{
       var_dump("UPDATE  pasien_resep SET
      dosis='".$dosis."',
      jumlah_perhari= '".$jumlah_perhari."',  
      number_of_day = '".$number_of_day."', 
      instruksi1= '".$instruksi1."',
      instruksi2 = '".$instruksi2."',
      indikasi= '".$indikasi."',
      total_cost = '".$total_cost."',      
      total_sell = '".$total_sell."'

      WHERE id='".$id."' " );

    }

   


?>