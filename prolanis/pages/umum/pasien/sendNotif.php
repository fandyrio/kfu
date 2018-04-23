<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "../../../../data/constanta.php";
include "../../../../config/conn.php";
/*$arrPhoneNumber=$_POST['arr'];
$idKlinik=$_POST['idKlinik'];

$getDataKlnik=pg_query("SELECT * from master_unit where id='$idKlinik'");
$fetchDataKlinik=pg_fetch_assoc($getDataKlnik);
$idOutlet=$fetchDataKlinik['id_outlet'];
echo $idOutlet;
$numberOfArr=sizeof($arrPhoneNumber);*/
$idUnit=$_SESSION['id_units'];

//SHOW ALL SCHEDULE
//===================================
$getSchedule=pg_query("SELECT * from pro_jadwal pj join pro_jadwal_dtl pjd on pjd.id_jadwal=pj.id
join pro_nama pn on pn.id=pj.id_pro
 where pj.tgl_akhir > now()");
$jumlah=pg_num_rows($getSchedule);


if($jumlah == 0)
{
    echo "Tidak ada jadwal";
}
else
{
 
  while($fetchSchedule=pg_fetch_assoc($getSchedule))
  {
    $toDate=date('d');
    $toDayName=date('l');
    $dateEvent=date('Y-m-d', strtotime("+1 days"));
    $jenisKegiatan=$fetchSchedule['nama'];
    $jam=$fetchSchedule['jam'];
    if($fetchSchedule['id_literasi']==0)//Kegiatan perbulan
    {
      //perbulan
     /* $todate=date('d');
      $tglNotif=strtotime($fetchSchedule['tgl_awal']);
      $dateSchedule=date('d', $tglNotif);
      $dateNotif=$dateSchedule-1;

      if($todate==$dateNotif)*/
      if($fetchSchedule['day_notif']==0)//kegiatan tiap tgl 1
      {
        $lastDayThisMonth = date("Y-m-t");
        //Print it out for example purposes.
        $toDay=date('Y-m-d');
        if($toDay==$lastDayThisMonth)
        {
          sendNotification($jam, $jenisKegiatan, $dateEvent,$idUnit);
        }
      }
      else//kegiatan tiap bulan selain tgl 1
      {
        if($toDate==$fetchSchedule['day_notif'])
        {
          sendNotification($jam, $jenisKegiatan, $dateEvent,$idUnit);
        }
      }
    }
    else if($fetchSchedule['id_literasi']==1 || $fetchSchedule['id_literasi']==2 || $fetchSchedule['id_literasi']==3)
    {
      if($toDayName==$fetchSchedule['day_notif'])
      {
        sendNotification($jam, $jenisKegiatan, $dateEvent,$idUnit);
      }
    }
  }
    
}


function sendNotification($jam, $jenisKegiatan, $dateEvent,$idUnit)
{
  $getDataUnit=pg_query("SELECT * from master_unit where id='$idUnit'");
  $fetchDataUnit=pg_fetch_assoc($getDataUnit);
  $idOutlet=$fetchDataUnit['id_outlet'];

  $getDataPasien=pg_query("SELECT mp.* from pasien_tindak_lanjut tl
                          JOIN master_pasien mp on (mp.id=tl.id_pasien) 
                          WHERE tl.id_unit='$_SESSION[id_units]' AND tl.id_tindak_lanjut='3' ");

  $arrNoHp=array();
  while($fetchDataPasien=pg_fetch_assoc($getDataPasien))
  {
    array_push($arrNoHp, $fetchDataPasien['no_handphone']);
  }
  $message="Yth, Bpk/Ibu Peserta Prolanis, Besok tgl ".$dateEvent." Pukul ".$jam." Kita akan mengadakan kegiatan ".$jenisKegiatan.". Terimakasih";
   $data=array(
      "phoneNo"=>$arrNoHp,
      "message"=>$message
  );
   $dataPost=json_encode($data);
     $url=API_SMS;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);   
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');        
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
               'Content-Type:application/json',
                'X-Auth-Token:p7riBrL1PGOKtDveaymsl2LZvWiQYDQJltan96bj',
                'X-Auth-OutletId:'.$idOutlet,
                'X-Auth-BvkUserId:1'));
            curl_setopt($ch, CURLOPT_URL, $url);    
            $return = curl_exec($ch);
}
?>
