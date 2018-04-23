<?php
include "constanta.php";
$noBPJS=$_GET['noBPJS'];
$post_data=array(
	"no_peserta" => "$_GET[noBPJS]"
);
$post_data = json_encode($post_data);
//echo $post_data;
//		echo '<br>' . config_item('api_url') . $url;
		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, API_BPJS);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
						'Content-Type: application/json',
						'Accept: application/json',
						'X-cons-id: 0001',
						'X-timestamp: 1460627850' ,
						'X-signature: naAMjzpnyLKt4B3QLWCW8lRA7D+aqJ/jWqhT2mI40vw=',
						'Content-Length: ' . strlen($post_data))                                                                       
		);
		
		// grab URL and pass it to the browser
		$return = curl_exec($ch);
		//var_dump($return);
		$data=json_decode($return, true);
		
		if($data['error']==0)
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
		}
//		log_message('debug', json_encode(curl_getinfo($ch, )));

		if (curl_errno($ch)) { 
		   print curl_error($ch); 
		} 
		// close cURL resource, and free up system resources
		curl_close($ch);
?>