<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../data/constanta.php";
include "../../../config/conn.php";

$unitId=$_SESSION['id_units'];
$idCatalog=$_POST['id'];
$getDataUnit=pg_query("SELECT * from master_unit where id='$unitId'");
$fetchDataUnit=pg_fetch_assoc($getDataUnit);
$idOutlet=$fetchDataUnit['id_outlet'];

$url=API_CEK_STOK."/".$idCatalog;
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
		//$data=json_decode($return, true);
		//print_r($return);
		print_r($return);

?>