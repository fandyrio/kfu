<?php

include "../../../../config/conn.php";
include "constanta.php";

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(0);

$id_pasien = $_POST['id_pasien'];
$id_kunjungan = $_POST['id_kunjungan'];

$dateNow=date('Y-m-d');
$hourNow=date('h:i:s');

/*$id_pasien ='22';
$id_kunjungan ='22';*/

$getKunjungan=pg_query("SELECT * from kunjungan where id='$id_kunjungan'");
$fetchKunjungan=pg_fetch_assoc($getKunjungan);
if($fetchKunjungan['prb']=="Y")
{
  $prb=true;
}
else
{
  $prb=false;
}


$row = pg_fetch_array(pg_query($dbconn, "SELECT * from transaksi_invoice where id_pasien='$id_pasien' and id_kunjungan='$id_kunjungan' "));
$SQLAntrian = pg_fetch_array(pg_query($dbconn, "SELECT * from antrian where id_pasien='$id_pasien' and id_kunjungan='$id_kunjungan' "));

$getDokter=pg_query("SELECT * from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$SQLAntrian[id_dokter]'");
$fetchDokter=pg_fetch_assoc($getDokter);
$idPoly=$fetchDokter['poly_id'];

$kode=substr($SQLAntrian[no_antrian],0,6);
$SQLunit = pg_fetch_array(pg_query($dbconn, "SELECT * from master_unit where kode='$kode' "));
$idOutlet=$SQLunit['id_outlet'];
//$idOutlet='341';
$SQLPasien = pg_fetch_array(pg_query($dbconn, "SELECT * from master_pasien where id='$id_pasien'"));

$yearDate=date('Y', $SQLPasien['tanggal_lahir']);
$thisYear=date('Y');
$selisih=$thisYear - $yearDate;

if($SQLPasien[jenkel]=='1'){
  $jenkel = "MALE";
}
{
  $jenkel = "FEMALE";
}
$SQLdetail = pg_query($dbconn, "SELECT * from transaksi_invoice_detail where id_invoice='$row[id]'");
$arrTindak=array();
while($fetchdetail=pg_fetch_assoc($SQLdetail))
  {
    if($fetchdetail[jenis]=='N')
    {
      $SQLtind = pg_fetch_array(pg_query($dbconn, "select * from tindakan where id ='$fetchdetail[id_detail]' "));
      if($SQLtind[status_tindakan]== 'Y'){
        if($SQLAntrian['dpp']=="Y")
        {
          $cat='NON_CLINIC_SERVICE';
        }
        else
        {
          $cat='CLINIC_SERVICE';
        }
      }else{
        $cat='PENDAFTARAN';
      }
      $arrTindak[]=array(
          "id" => $fetchdetail[id],
            "name" => $SQLtind[nama],
            "price"=> $fetchdetail[harga],
            "category" => $cat 
        );
    }
    
  }

$kodePenjamin=$SQLAntrian['id_kategori_harga'];
if($kodePenjamin==0)
{
  $kodePenjamin=null;
  $namaPenjamin='UMUM';
}
else
{
  $SQLkategori = pg_fetch_array(pg_query($dbconn, "SELECT * from master_kategori_harga where kode_penjamin='$kodePenjamin' and id_outlet='$idOutlet'"));
  $kodePenjamin=$SQLkategori['kode_penjamin'];
  $namaPenjamin=$SQLkategori['nama'];
}

$SQLReser = pg_fetch_array(pg_query($dbconn, "SELECT * from antrian_reservasi where no_antrian='$SQLAntrian[no_antrian]'"));

//var_dump($id_kunjungan);
  $getObat=pg_query("SELECT pro.*, ic.sap_code as sap_code, prk.*, cp.arti as cara_pakai from pasien_resep_order pro 
        join item_catalog ic on ic.catalog_id=pro.id_inv
        join pasien_resep_keterangan prk on prk.id_resep=pro.id_resep and prk.id_kunjungan=pro.id_kunjungan
        join cara_pakai cp on cp.id=prk.cara_pakai::integer
       where pro.id_kunjungan='$id_kunjungan' and ic.outlet_id='$idOutlet' and prk.status_racikan='NR'");

$jumlahData=pg_num_rows($getObat);
  $getNoResep=pg_query("SELECT * from pasien_no_resep where id_kunjungan='$id_kunjungan'");
      $fetchNoResep=pg_fetch_assoc($getNoResep);
      $noResep=$fetchNoResep['no_resep'];
      $publicIdResep=$fetchNoResep['public_id'];
      $cito=$fetchNoResep['cito'];
      if($cito=="Y")
      {
        $statusCito=true;
      }
      else
      {
        $statusCito=false;
      }

  $getMa=pg_query("SELECT * from phr where id=(select max(id) from phr where id_kunjungan='$id_kunjungan')");
  $fetchMa=pg_fetch_assoc($getMa);
  $no_MA=$fetchMa['no_ma'];

      $arr=array();
if($jumlahData>0)
{
    while($fetchObat=pg_fetch_assoc($getObat))
      {
        $signa=$fetchObat['xperh']."X".$fetchObat['operh'];
        $arr[]=array(
              "id"=> '1',
              "info"=> null,
              "quantity_bought"=> null,
              "quantity_presc"=> $fetchObat['jml'],
              "created_at"=> $dateNow.'T'.$hourNow.'+07:00',
              "updated_at"=> $dateNow.'T'.$hourNow.'+07:00',
              "prescription_id"=> '1',
              "item_id"=> $fetchObat['id_inv'],
              "item_name"=> $fetchObat['nama_brand'],
              "item_price"=> 0,
              "unit"=> null,
              "signa"=> $signa,
              "dose"=> $fetchObat['dosis'],//??
              "iter"=> 1,
              "det"=> null,
              "usage_instruction1"=> $fetchObat['cara_pakai'],//dimunum / dimakan / dioles
              "usage_instruction2"=>  
                array(),
              "erx_detail_id"=> null,
              "erx_detail_name"=> null
              );
      }
}
else
{
  $arr=array();
}

//================================
//RACIKAN
//================================
$getKetRacik=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$id_kunjungan' and status_racikan='R'");
$jumlahRacik=pg_num_rows($getKetRacik);
$arrRacikan=array();
if($jumlahRacik>0)
{
    while($fetchKetRacik=pg_fetch_assoc($getKetRacik))
    {

      $getObatRacik=pg_query("SELECT pro.*, ic.sap_code as sap_code, prk.*, cp.arti as cara_pakai from pasien_resep_order pro 
        join item_catalog ic on ic.catalog_id=pro.id_inv
        join pasien_resep_keterangan prk on prk.id_resep=pro.id_resep and prk.id_kunjungan=pro.id_kunjungan
        join cara_pakai cp on cp.id=prk.cara_pakai::integer
       where pro.id_kunjungan='$id_kunjungan' and ic.outlet_id='$idOutlet' and pro.id_resep='$fetchKetRacik[id_resep]'");

      while($fetchObatRacik=pg_fetch_assoc($getObatRacik))
      {
         $arrObatRacik[]=array(
            "id"=>1,
            "quantity_presc"=> 1,// jumlah obat, kalau dispense drug ga ada, jumlah obat di gabung jadi 1 racikan
            "quantity_bought"=> null,
            "quantity_item"=> $fetchObatRacik['jml'],//?
            "unit"=> null,
            "dose"=> $fetchObatRacik['dosis'],
            "drug_strength"=>$fetchObatRacik['dosis'],
            "item_id"=> $fetchObatRacik['id_inv'],
            "item_price"=> "0",
            "dispensed_drug_id"=> 1,
            "created_at"=> $dateNow.'T'.$hourNow.'+07:00',
            "updated_at"=> $dateNow.'T'.$hourNow.'+07:00'

          );
      }
      $signa=$fetchKetRacik['xperh']."X".$fetchKetRacik['operh'];
      $arrRacikan[]=array(
              "id"=> '1',
              "info"=> null,
              "concoct_instruction"=> null,
              "usage_instruction2"=> array(),   
              "usage_instruction1"=> $fetchObatRacik['cara_pakai'],//dimunum / dimakan / dioles
              "signa"=> $signa,
              "iter"=> 1,
              "det"=> null,
              "prescription_id"=> '1',
              "created_at"=> $dateNow.'T'.$hourNow.'+07:00',
              "updated_at"=> $dateNow.'T'.$hourNow.'+07:00',
              "drugs"=> $arrObatRacik
              );
    }
}
else
{
  $arrRacikan=array();
}

 if($jumlahRacik==0 && $jumlahData==0)
      {
        $isPrescription=false;
      }
      else
      {
        $isPrescription =true;
      }
//________________________________________________
//GET STATUS BPJS
//________________________________________________

$getPrb=pg_query("SELECT * from kunjungan where id='$id_kunjungan'");
$fetchPrb=pg_fetch_assoc($getPrb);
$statusPrb=$fetchPrb['prb'];
if($statusPrb=="")
{
  $statusPrbLast="";
}
else
{
  $statusPrbLast="PRB";
}
//================================================

$id_unit=$_SESSION['id_units'];
$post_data=array(
  "queueId" => $SQLAntrian[id], 
    "queueNo" => $SQLAntrian[no_antrian],
    "clinicId" => $SQLunit[id],
    "isPaid" => false,
    "reservationNo" => $SQLReser[id_reservasi],
    "isCito" =>$statusCito,
    "isPrb"=>$prb,
    "customerId"=>  $SQLPasien[customer_id],
    "services"=> $arrTindak,
    "insurer" => array(
        "code" => $kodePenjamin,
        "name" => $namaPenjamin,
        "memberNo" => null        
    ),   
    "patient" => array(
          "id" => $SQLPasien[public_id],
          "name" => $SQLPasien[nama],
          "dateOfBirth" => $SQLPasien[tanggal_lahir],
          "placeOfBirth" => $SQLPasien[tempat_lahir],
          "gender" => $jenkel, 
          "handphone" => $SQLPasien[no_handphone],
          "education" => null,
          "work" => null,
          "allergy" => null,
          "address" => array(
            "districtCode" => null,
            "street" => null,            
            "cityCode" => null,
            "provinceCode" => null
          )         
        ),
    "isPrescription"=>$isPrescription,
    "prescription"=>array(
      "publicId" => $publicIdResep, 
      'data'=>array(
          'id'=>1,
          'patient_birthdate'=> $SQLPasien[tanggal_lahir],
          'bpjs_category'=> $statusPrbLast, //kronis, kapitasi, PRB
          'prescription_number'=>$noResep,
          'order_item_id'=>null,
          'medical_record_public_id'=>$no_MA,
          'doctor'=>$fetchDokter['nama'],
          "doctor_address"=>$SQLunit['alamat'],
          'patient_name'=>$SQLPasien['nama'],
          'patient_age'=>$selisih,
          'patient_age_isyear'=> true,
          'patient_address'=>$SQLPasien['alamat'],
          'patient_phone'=>$SQLPasien['no_handphone'],
          'qr_code'=>'prescrption:'.$noResep,
          'pharmacist'=>null,
          'sia'=>null,
          'created_at'=>$dateNow.'T'.$hourNow.'+07:00',
          'updated_at'=>$dateNow.'T'.$hourNow.'+07:00',
          'prescription_number_base'=>null,
          'is_from_erx'=>null,
          'doctor_sip'=>null,
          'doctor_contact_number'=>null,
          'patient_gender'=>null,
          'patient_weight'=>null,
          'erx_not_active'=>null,
          'sync_at'=>null,
          'poly'=>$fetchDokter['name'], // masih hardcode
          'non_dispensed_drugs'=>
              $arr,
          'dispensed_drugs'=>
              $arrRacikan
      )
  )
);
$post_data = json_encode($post_data);



printf($post_data);

       //$ch = curl_init();
        $url=API_POST_TINDAKAN;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);   
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Content-Type:application/json',
            'X-Auth-Token:p7riBrL1PGOKtDveaymsl2LZvWiQYDQJltan96bj',
            'X-Auth-OutletId:'.$idOutlet,
            'X-Auth-BvkUserId:1'));
        curl_setopt($ch, CURLOPT_URL, $url);    
        $return = curl_exec($ch);
        $data=json_decode($return, true);
        $message="";
        $insertAPI=pg_query("INSERT INTO post_api(id_kunjungan,post,message) values ('$id_kunjungan', '$post_data', '$message')");

    /*print_r($url);
    print_r($idOutlet);*/
    //print_r($return);

    curl_close($ch);
?>