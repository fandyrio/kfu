<?php
session_start();
include "constanta.php";
include "../config/conn.php";
$id_unit=$_SESSION['id_units'];

$getIdOutlet=pg_query("SELECT * from master_unit where id='$id_unit'");
$fetchUnit=pg_fetch_assoc($getIdOutlet);
$idOutlet=$fetchUnit['id_outlet'];



$reservasi=$_GET['idReservasi'];

$explode=explode(":", $reservasi);

$idReservasi=$explode[1];


//echo $post_data;
//		echo '<br>' . config_item('api_url') . $url;
		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		$url=API_RESERVE.$idReservasi;


 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST  ,'GET');        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Content-Type:application/json',
		'X-Auth-Token:p7riBrL1PGOKtDveaymsl2LZvWiQYDQJltan96bj',
'X-Auth-OutletId:'.$idOutlet,
'X-Auth-BvkUserId:1'));
        curl_setopt($ch, CURLOPT_URL, $url);         

		// grab URL and pass it to the browser
		$return = curl_exec($ch);
		//var_dump($return);
		$data=json_decode($return, true);
		print_r($return);
		
		/*if($data['error']==0)
		{
			if($data['data']['keterangan']=="AKTIF")
			{
				print_r($return);
			}
			else
			{
				print_r($return);
			}
			
		}
		else
		{
			print_r($return);
		}*/
//		log_message('debug', json_encode(curl_getinfo($ch, )));

		/*if (curl_errno($ch)) { 
		   print curl_error($ch); 
		} */
		// close cURL resource, and free up system resources
		curl_close($ch);
?>