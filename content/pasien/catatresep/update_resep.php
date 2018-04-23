<?php
error_reporting(1);
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
      diberi='$diberi',
      jumlah_perhari= '".$jumlah_perhari."',  
      number_of_day = '".$number_of_day."', 
      instruksi1= '".$instruksi1."',
      indikasi = '".$indikasi."',
      qty = '".$qty."'

      WHERE id='".$id."' "    
      );
    if($res){

    }else{
      

    }

    $getIdKunjungan=pg_query("SELECT pro.*, mu.kode as kode_outlet from pasien_resep_order pro join master_unit mu on mu.id=pro.id_unit where pro.id='$id'");
    $fetchKunjungan=pg_fetch_assoc($getIdKunjungan);
    $noKunjungan=$fetchKunjungan['id_kunjungan'];

    $check=pg_query("SELECT * from pasien_no_resep where id_kunjungan='$noKunjungan'");
    $jumlah=pg_num_rows($check);
    if($jumlah==0)
    {
      $getMax=pg_query("SELECT max(id) as maxId from pasien_no_resep");
      $fetchMax=pg_fetch_assoc($getMax);
      $public_id=$fetchMax['maxid']+=1;
      $sprintF=sprintf("%06d", $public_id);

      $unikUnit=sprintf("%03d", $_SESSION['id_units']);
      $public_idResep="R".$unikUnit.'0'.$sprintF;

      $noResep=$fetchKunjungan['kode_outlet'].' / '.date('Y').date('m').' / '.$sprintF;

      $insert=pg_query("INSERT into pasien_no_resep (id_kunjungan, public_id, no_resep) values ('$noKunjungan', '$public_idResep', '$noResep')");

    }

   


?>