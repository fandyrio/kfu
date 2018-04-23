<?php
session_start();
include "../config/conn.php";
include "constanta.php";
$noRM=$_GET['id'];

$id_unit=$_SESSION['id_units'];

$getIdOutlet=pg_query("SELECT * from master_unit where id='$id_unit'");
$fetchUnit=pg_fetch_assoc($getIdOutlet);
$idOutlet=$fetchUnit['id_outlet'];
$kodeUnit=$fetchUnit['kode'];

$getDataPasien=pg_query("SELECT * from master_pasien where no_rm='$noRM'");
$dataID=pg_fetch_assoc($getDataPasien);
$id_pasien=$dataID['id'];

$getDataAntrian=pg_query("SELECT * from antrian where id_pasien='$id_pasien' and status_antrian='Y'");//perbaikan = ambil berdasarkan status_aktif=y
$fetchAntrian=pg_fetch_assoc($getDataAntrian);
$id_kunjungan=$fetchAntrian['id_kunjungan'];

$getKeluhan=pg_query("SELECT pk.*, b.nama_body as nama_body, lb.nama_lokasi as nama_lokasi, s.nama_sympton
	from pasien_keluhan pk join master_body b on pk.id_body=b.id
	join master_lokasi_body lb on pk.id_lokasi=lb.id
	join pasien_keluhan_detail pkd on pkd.id_pasien_keluhan=pk.id
	left join master_sympton s on pkd.id_symptom=s.id 
	where pk.id_pasien='$id_pasien' and pk.id_kunjungan='$id_kunjungan'");
$fetchKeluhan=pg_fetch_assoc($getKeluhan);

$getFisik=pg_query("select max(id) from pasien_fisik where id_pasien='$id_pasien'");
$fetchIdFisik=pg_fetch_assoc($getFisik);
$idFisik=$fetchIdFisik['max'];
var_dump($idFisik);


$dataFisik=pg_query("SELECT pf.*, f.nama as nama_fisik,pfd.id_fisik as id_fisik, pfd.nilai as nilai_fisik
	from pasien_fisik pf 
	join pasien_fisik_detail pfd on pfd.id_pasien_fisik=pf.id
	join fisik f on f.id=pfd.id_fisik
	where pf.id_pasien='$id_pasien' and pf.id='$idFisik' and pf.id_kunjungan='$id_kunjungan'");



while($fetchFisik=pg_fetch_assoc($dataFisik))
{
	if($fetchFisik['id_fisik']==1)
	{
		$valueBentukTubuh=$fetchFisik['nilai_fisik'];
	}
	else if($fetchFisik['id_fisik']==2)
	{
		$valueBeratBadan=$fetchFisik['nilai_fisik'];
	}
	else if($fetchFisik['id_fisik']==3)
	{
		$valueTinggiBadan=$fetchFisik['nilai_fisik'];
	}
	else if($fetchFisik['id_fisik']==4)
	{
		$valueTekananDarah=$fetchFisik['nilai_fisik'];
	}
	else if($fetchFisik['id_fisik']==5)
	{
		$valueNadi=$fetchFisik['nilai_fisik'];
	}
	else if($fetchFisik['id_fisik']==6)
	{
		$valuePernafasan=$fetchFisik['nilai_fisik'];
	}
}



$getTindakan=pg_query("SELECT tvd.*, t.nama as nama_tindakan , t.id as id_tindakan
	from transaksi_invoice_detail tvd 
	join tindakan t on t.id=tvd.id_detail
	where tvd.id_pasien='$id_pasien' and tvd.id_kunjungan='$id_kunjungan'");
$tindakan="";
$tindakan_id="";
$arr_tindakan_id=array();
$arr_tindakan_nama=array();
while($fetchTindakan=pg_fetch_assoc($getTindakan))
{
	$tindakan .= $fetchTindakan['nama_tindakan']." , ";
	$tindakan_id .= $fetchTindakan['id_tindakan']." , ";
	array_push($arr_tindakan_id, $tindakan_id);
	array_push($arr_tindakan_nama, $tindakan);
}
//echo $tindakan_id;



/*$getMaxAntrian=pg_query("SELECT max(id) from antrian where id_pasien='$id_pasien'");
$fetchMaxAntrian=pg_fetch_assoc($getMaxAntrian);
$jumlahMaxAntrian=$fetchMaxAntrian['max'];*/



$getDiagnosa=pg_query("SELECT pd.*, icd.nama as nama_icd from pasien_diagnosa pd 
	join pasien_diagnosa_detail pdd on pdd.id_pasien_diagnosa=pd.id
	join master_icd10 icd on icd.id=pdd.id_diagnosa
	where pd.id_pasien='$id_pasien' and pd.id_kunjungan='$id_kunjungan'");

$diagnosa="";
while($fetchDiagnosa=pg_fetch_assoc($getDiagnosa))
{
	$diagnosa .=$fetchDiagnosa['nama_icd']." , ";
}

$getDokter=pg_query("SELECT * from master_karyawan where id='$fetchAntrian[id_dokter]'");
$fetchDokter=pg_fetch_assoc($getDokter);
$idPoly=$fetchDokter['poly_id'];

$tekanan=explode("/", $valueTekananDarah);
$systolic=$tekanan[0];
$dystolic=$tekanan[1];

//generate Public ID / Nomor PHR
$getMaxPHR=pg_query("SELECT max(id) from phr");
$fetchPHR=pg_fetch_assoc($getMaxPHR);
$idPHR=$fetchPHR['id']+=1;
$kodePHR=$kodeUnit.sprintf("%07s", $idPHR);

$phr=array(
	'data'=>
		array(
			"polyclinic_id"=> $idPoly,
			"main_complaint"=> $fetchKeluhan['nama_body'].','.$fetchKeluhan['nama_lokasi'].','.$fetchKeluhan['nama_sympton'].','.$fetchKeluhan['catatan'],
			"time_complaint"=> $fetchKeluhan['lama_keluhan'],
			"indication"=> "",
			"caused_by"=> "",
			"notes"=> "",
			"systolic_blood_pressure"=> $systolic,
			"diastolic_blood_pressure"=> $dystolic,
			"pulse"=> $valueNadi,
			"axillary_temperature"=> "37", 
        	"oral_temperature"=> "37", 
        	"rectal_temperature"=> "37",
	        "weight"=> $valueBeratBadan,
	        "height"=> $valueTinggiBadan,
	        "icd_code"=> "I10", 
	        "diagnosys"=> $diagnosa, //diagnosisi masig belum
	        "icd_description"=> "",
	        "old_case"=> "true",
	        "treatment_at"=> date('d-F-y'),
	        "status"=> "Ditangani",
	        "treatment_action"=> $arr_tindakan_id,
        	"treatment_action_name"=> $arr_tindakan_nama,
			),
	 	"patientId"=>$dataID['public_id'],
    	"registrationId"=> "",
    	"doctorId"=> $fetchDokter['id_dokter'],//
    	"clarificationsRequest"=> [],
    	"publicId"=> $kodePHR //isi dengan nomer PHR kalian
	);





	$post_data = json_encode($phr);
//echo $post_data;
//		echo '<br>' . config_item('api_url') . $url;
		// create a new cURL resource

		$ch = curl_init();
		$header = array(
            'Content-Type:application/json',
		'X-Auth-Token:p7riBrL1PGOKtDveaymsl2LZvWiQYDQJltan96bj',
'X-Auth-OutletId:'.$idOutlet,
'X-Auth-BvkUserId:1');
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, API_POST_PHR);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		// grab URL and pass it to the browser
		$return = curl_exec($ch);
		//var_dump($return);
		$data=json_decode($return, true);
		
		//var_dump($return);
		
//		log_message('debug', json_encode(curl_getinfo($ch, )));

		if (curl_errno($ch)) { 
		   print curl_error($ch); 
		} 
		// close cURL resource, and free up system resources
		curl_close($ch);

		if(isset($data['error']))
		{
			echo "<script>alert('$post_data');window.history.go(-1);</script>";	

		}
		else
		{
			echo "<script>alert('Data berhasil Dikirimkan')</script>";
			$no_MA=$data['id'];
			$insertToPHR=pg_query("INSERT into phr (kode,id_kunjungan, no_ma) values ('$kodePHR','$fetchAntrian[id_kunjungan]', '$no_MA')");
			$yearDate=date('Y', $dataID['tanggal_lahir']);
			$thisYear=date('Y');
			$selisih=$thisYear - $yearDate;

			$dateNow=date('Y-m-d');
			$hourNow=date('h:i:s');

			$getNoResep=pg_query("SELECT * from pasien_no_resep where id_kunjungan='$fetchAntrian[id_kunjungan]'");
			$fetchNoResep=pg_fetch_assoc($getNoResep);
			$noResep=$fetchNoResep['no_resep'];
			$publicIdResep=$fetchNoResep['public_id'];

			$getMaxData=pg_query("SELECT MAX(id) as max_id from pasien_no_resep");
			$dataMAX=pg_fetch_assoc($getMaxData);
			$jumlah=$dataMAX['max_id']+1;
			$sprintF=sprintf("%06d", $jumlah);
			$unikUnit=sprintf("%03d", $_SESSION['id_units']);
			$public_idResep="R".$unikUnit.''.$sprintF;

			  $getObat=pg_query("SELECT pro.*, ic.sap_code as sap_code, prk.*, cp.arti as cara_pakai from pasien_resep_order pro 
        join item_catalog ic on ic.catalog_id=pro.id_inv
        join pasien_resep_keterangan prk on prk.id_resep=pro.id_resep and prk.id_kunjungan=pro.id_kunjungan
       left join cara_pakai cp on cp.id=prk.cara_pakai::integer
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
            "quantity_presc"=> 1,
            "quantity_bought"=> null,
            "quantity_item"=> $fetchObatRacik['jml'],
            "unit"=> null,
            "dose"=> $fetchObatRacik['dosis'],
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


			


			$resep=array(
				'publicId'=>$publicIdResep,
				'patientId'=>$dataID['public_id'],
				'customerId'=>$dataID['customer_id'],//c20083666h
				'data'=>array(
					'id'=>1,
					'prescription_number'=>$noResep,
					'order_item_id'=>null,
					'medical_record_public_id'=>$no_MA,
					'doctor'=>$fetchDokter['nama'],
					'patient_name'=>$dataID['nama'],
					'patient_age'=>$selisih,
					'patient_age_isyear'=> true,
					'patient_address'=>$dataID['alamat'],
					'patient_phone'=>$dataID['no_handphone'],
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
					'non_dispensed_drugs'=>
							$arr,
					'dispensed_drugs'=>
						$arrRacikan
					)
				);

$post_resep = json_encode($resep);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, API_POST_RESEP);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_resep);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$return2 = curl_exec($ch);

$data2=json_decode($return2, true);
		
		
var_dump($post_resep);

$update=pg_query("UPDATE kunjungan set status_sync='Y' where id='$id_kunjungan'");
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		
		

?>