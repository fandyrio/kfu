 <?php
include "../config/conn.php";

$urlDetail=API_DETAIL_OBAT."10123";
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
							'X-Auth-OutletId:341',
							'X-Auth-BvkUserId:1'));
			curl_setopt($ch, CURLOPT_URL, $urlDetail);         
								
			$returnData = curl_exec($ch);
								
			$dataDetail=json_decode($returnData, true);
var_dump($dataDetail);