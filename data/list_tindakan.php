<?php
include "../config/conn.php";
header("Content-Type: application/json");

$signature=$_SERVER["HTTP_SIGNATURE"];
$type=$_SERVER["HTTP_CONTENT_TYPE"];
$address=$_SERVER["REMOTE_ADDR"];

$request_method=$_SERVER["REQUEST_METHOD"]; 

if($request_method == 'GET')
{
	if($signature=='naAMjzpnyLKt4B3QLWCW8lRA7D+aqJ/jWqhT2mI40vw='){
				$tampil=pg_query($dbconn,"SELECT * FROM tindakan");
				while($r=pg_fetch_array($tampil)){
					$item[] = array(
						"id"			=> $r['id'],
						"nama"			=> $r['nama'],
						"kode"			=> $r['kode']
					);
				}			
				$json = array(
					'response'		=> 'success',
					'tindakan'	=> $item
				);
			}
		else{
			$json = array(
				'response'	=> 'Invailed key',
			);
		}
}
	else{
		$json = array(
			'response'	=> 'Invailed method',
		);
	}

echo json_encode($json);
?>