<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Jakarta");
session_start();
include "constanta.php";
include "../config/conn.php";




//===========================
//GET DATA UNIT
//===========================
$id_unit=$_SESSION['id_units'];
//$id_unit=11;
$today=date("Y-m-d");
$getIdOutlet=pg_query("SELECT * from master_unit where id='$id_unit'");
$fetchUnit=pg_fetch_assoc($getIdOutlet);
$idOutlet=$fetchUnit['id_outlet'];
$kode=$fetchUnit['kode'];

$getLastSync=pg_query("SELECT * from list_sync where outlet_id='$idOutlet' and nama_sync='sync_obat'");
$fetchLastSync=pg_fetch_assoc($getLastSync);
$tglSync=$fetchLastSync['last_update'];

$since=$tglSync."T00:00:00.000Z";
//$since="2018-12-04T00:00:00.000Z";

////===========================

//============================
//API SYNC OBAT
//============================
$url=API_GET_OBAT."?since=".$since;
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
		//print_r($return);
//============================

$namaFile="csv/csv_obat".$idOutlet.".csv";

$fp = fopen($namaFile, 'a+');
if ( !$fp ) 
{
  	echo 'last error: ';
 	var_dump(error_get_last());
}
else 
{
  echo "ok <br/>";
}
//echo $data;

$myfile = fopen($namaFile, "w") or die("Unable to open file!");
fwrite($myfile, $return);
fclose($myfile);


	
