<?php

include "../../config/conn.php";
include "constanta.php";
//echo $_GET['id_pasien'];
function API_POST_PATIENT($id_pasien)
{


	$id_unit=$_SESSION['id_units'];

	$getIdOutlet=pg_query("SELECT * from master_unit where id='$id_unit'");
	$fetchUnit=pg_fetch_assoc($getIdOutlet);
	$idOutlet=$fetchUnit['id_outlet'];

	$getData=pg_query("SELECT * from master_pasien where public_id='$id_pasien'");
	$data=pg_fetch_assoc($getData);

	if($data["jenkel"]=="2")
	{
		$jk="FEMALE";
	}
	else
	{
		$jk="MALE";
	}

	//get District code
	$getDistrict=pg_query("SELECT * from master_kecamatan where id='$data[id_kecamatan]'");
	$districtId=pg_fetch_assoc($getDistrict);	


	//get data city
	$getCity=pg_query("SELECT * from master_kabupaten where id='$data[id_kabupaten]'");
	$cityId=pg_fetch_assoc($getCity);	

	//get data province
	$getProvince=pg_query("SELECT * from master_provinsi where id='$data[id_provinsi]'");
	$provinceId=pg_fetch_assoc($getProvince);

	//code
	$provinceCode=$provinceId['province_code'];
	$cityCode=$cityId['city_code'];
	$districtCode=$districtId['district_code'];

	$post_data=array(
		"id"=>$data['public_id'],
		"name"=> $data["nama"],
		"dateOfBirth"=>$data['tanggal_lahir'],
		"placeOfBirth"=>$data['tempat_lahir'],
		"gender"=>$jk,
		"email"=>$data['email'],
		"handphone"=> $data['no_handphone'],
	    "phone"=> $data['no_telepon'],
	    "education"=> "",
	    "work"=> "",
	    "allergy"=> "",
	    "address"=> 
	    	array(
	    		
		    	"street"=> $data['alamat'],
		        "postcode"=> "",
		        "districtId"=> $districtCode,
		        "cityId"=> $cityCode,
		        "provinceId"=> $provinceCode
	    		
	    ),
   		 "customerId"=> $data['customer_id']
	);
	$post_data = json_encode($post_data);
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
		curl_setopt($ch, CURLOPT_URL, API_POST_PATIEN);
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
		if(isset($data['error']))
		{
			return $data['message'];
		}

		
		
//		log_message('debug', json_encode(curl_getinfo($ch, )));

		if (curl_errno($ch)) { 
		   print curl_error($ch); 
		} 
		// close cURL resource, and free up system resources
		curl_close($ch);


}

function API_POST_CONFIRM($idReservasi)
{
	$id_unit=$_SESSION['id_units'];

	$getIdOutlet=pg_query("SELECT * from master_unit where id='$id_unit'");
	$fetchUnit=pg_fetch_assoc($getIdOutlet);
	$idOutlet=$fetchUnit['id_outlet'];
//echo $post_data;
//		echo '<br>' . config_item('api_url') . $url;
		// create a new cURL resource
	$url=API_RESERVE.$idReservasi;
	$header = array(
            'Content-Type:application/json',
		'X-Auth-Token:p7riBrL1PGOKtDveaymsl2LZvWiQYDQJltan96bj',
'X-Auth-OutletId:'.$idOutlet,
'X-Auth-BvkUserId:1');


	$ch = curl_init($url);
	$data = array(
 			"status"=>"CONFIRMED"
	  );
	$put_data=json_encode($data);
	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $put_data);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_URL, $url); 

	// Make the REST call, returning the result
	$response = curl_exec($ch);

		

		// grab URL and pass it to the browser
		
		//var_dump($return);
		$result=json_decode($response, true);
		print_r($result);
		
	
		curl_close($ch);
}


?>
