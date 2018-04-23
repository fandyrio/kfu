<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../config/conn.php";
include "constanta.php";

//$id_unit=$_SESSION['id_units'];
$id_unit=11;

$getOutletId=pg_query("SELECT * from master_unit where id='$id_unit'");
$fetchOutletId=pg_fetch_assoc($getOutletId);
$outletId=$fetchOutletId['id_outlet'];

$getLastSync=pg_query("SELECT * from list_sync where outlet_id='$outletId' and nama_sync='sync_penjamin'");
$fetchSyncPenjamin=pg_fetch_assoc($getLastSync);
$lastUpdate=$fetchSyncPenjamin['last_update'];
//$lastUpdate="2017-01-01";
$urlAPIGETPENJAMIN=API_GET_PENJAMIN."?since=".$lastUpdate."T00:00:00.000Z";

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
			'X-Auth-OutletId:'.$outletId,
			'X-Auth-BvkUserId:1'));
curl_setopt($ch, CURLOPT_URL, $urlAPIGETPENJAMIN);  

// grab URL and pass it to the browser
$return = curl_exec($ch);
//var_dump($return);
$data=json_decode($return, true);
//print_r($return); 


$namaFile="csv/csv_penjamin.csv";

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

$myfile = fopen($namaFile, "w") or die("Unable to open file!");
fwrite($myfile, $return);
fclose($myfile);  

if (($handle = fopen($namaFile, "r")) !== FALSE) 
	{
		$no=1;
  		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
  		{
	    	$num = count($data);
	    	//$row++;
	    	if($data[1]!='last_update')
	    	{
	    		echo $data[1];
	    		$getDataPenjamin=pg_query("SELECT * from master_kategori_harga where id_ss='$data[0]' and id_outlet='$outletId'");
	    		$jumlah=pg_num_rows($getDataPenjamin);
	    		if($jumlah==0)
	    		{
	    			//-======================================
	    			//API GET DETAIL PENJAMIN
	    			//-======================================
	    			$urlGetDetailPenjamin=API_GET_DETAIL_PENJAMIN."/".$data[0];

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
								'X-Auth-OutletId:'.$outletId,
								'X-Auth-BvkUserId:1'));
					curl_setopt($ch, CURLOPT_URL, $urlGetDetailPenjamin);
					$returnData=curl_exec($ch);
					$dataDetail=json_decode($returnData, true);
					//var_dump($dataDetail['insurerCode']);
					$insuranceCode=$dataDetail['insurerCode'];
					$insurerName=$dataDetail['insurerName'];
	    			//====================================================================================================

	    			$insertData=pg_query("INSERT INTO master_kategori_harga (nama,alamat,telepon,id_jenis,username,password,waktu_login,waktu_edit,kode_penjamin,id_outlet,id_ss) values ('$insurerName','Unknow','unknow',NULL,'0','unknow','unknow','','$insuranceCode','$outletId','$data[0]')");
	    			echo $data[0]." tidak ada";
	    		}
	    	}
	    }
	  }   

?>