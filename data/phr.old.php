<?php
session_start();
include "../config/conn.php";
include "constanta.php";
$noRM=$_GET['id'];

$id_unit=$_SESSION['id_units'];

$getIdOutlet=pg_query("SELECT * from master_unit where id='$id_unit'");
$fetchUnit=pg_fetch_assoc($getIdOutlet);
$idOutlet=$fetchUnit['id_outlet'];

$getDataPasien=pg_query("SELECT * from master_pasien where no_rm='$noRM'");
$dataID=pg_fetch_assoc($getDataPasien);
$id_pasien=$dataID['id'];


$getKeluhan=pg_query("SELECT pk.*, b.nama_body as nama_body, lb.nama_lokasi as nama_lokasi, s.nama_sympton
	from pasien_keluhan pk join master_body b on pk.id_body=b.id
	join master_lokasi_body lb on pk.id_lokasi=lb.id
	join pasien_keluhan_detail pkd on pkd.id_pasien_keluhan=pk.id
	left join master_sympton s on pkd.id_symptom=s.id 
	where pk.id_pasien='$id_pasien'");
$fetchKeluhan=pg_fetch_assoc($getKeluhan);

$getFisik=pg_query("select max(id) from pasien_fisik where id_pasien='$id_pasien'");
$fetchIdFisik=pg_fetch_assoc($getFisik);
$idFisik=$fetchIdFisik['max'];
var_dump($idFisik);


$dataFisik=pg_query("SELECT pf.*, f.nama as nama_fisik,pfd.id_fisik as id_fisik, pfd.nilai as nilai_fisik
	from pasien_fisik pf 
	join pasien_fisik_detail pfd on pfd.id_pasien_fisik=pf.id
	join fisik f on f.id=pfd.id_fisik
	where pf.id_pasien='$id_pasien' and pf.id='$idFisik'");



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
	where tvd.id_pasien='$id_pasien'");
$tindakan="";
$tindakan_id="";
while($fetchTindakan=pg_fetch_assoc($getTindakan))
{
	$tindakan .= $fetchTindakan['nama_tindakan']." , ";
	$tindakan_id .= $fetchTindakan['id_tindakan']." , ";
}
//echo $tindakan_id;



$getMaxAntrian=pg_query("SELECT max(id) from antrian where id_pasien='$id_pasien'");
$fetchMaxAntrian=pg_fetch_assoc($getMaxAntrian);
$jumlahMaxAntrian=$fetchMaxAntrian['max'];

$getDataAntrian=pg_query("SELECT * from antrian where id_pasien='$id_pasien' and id='$jumlahMaxAntrian'");
$fetchAntrian=pg_fetch_assoc($getDataAntrian);

$getDiagnosa=pg_query("SELECT pd.*, icd.nama as nama_icd from pasien_diagnosa pd 
	join pasien_diagnosa_detail pdd on pdd.id_pasien_diagnosa=pd.id
	join master_icd10 icd on icd.id=pdd.id_diagnosa
	where pd.id_pasien='$id_pasien'");

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
			"axillary_temperature"=> "33", 
        	"oral_temperature"=> "32", 
        	"rectal_temperature"=> "32",
	        "weight"=> $valueBeratBadan,
	        "height"=> $valueTinggiBadan,
	        "icd_code"=> "I.10", 
	        "diagnosys"=> $diagnosa, //diagnosisi masig belum
	        "icd_description"=> "",
	        "old_case"=> "true",
	        "treatment_at"=> date('d-F-y'),
	        "status"=> "Ditangani",
	        "treatment_action"=> $tindakan_id,
        	"treatment_action_name"=> $tindakan,
			),
	 	"patientId"=>$dataID['public_id'],
    	"registrationId"=> "",
    	"doctorId"=> $fetchAntrian['id_dokter'],//
    	"clarificationsRequest"=> [],
    	"publicId"=> "M111L00000027" //isi dengan nomer PHR kalian
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
		
		var_dump($return);
		
//		log_message('debug', json_encode(curl_getinfo($ch, )));

		if (curl_errno($ch)) { 
		   print curl_error($ch); 
		} 
		// close cURL resource, and free up system resources
		curl_close($ch);

		if(isset($data['error']))
		{
			echo "<script>alert('Error');window.history.go(-1);</script>";	

		}
		else
		{
			echo "<script>alert('Data berhasil Dikirimkan')</script>";	
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		
		

?>