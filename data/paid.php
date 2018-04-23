<?php
include "../config/conn.php";
header("Content-Type: application/json");

$signature=$_SERVER["HTTP_SIGNATURE"];
$type=$_SERVER["HTTP_CONTENT_TYPE"];
$address=$_SERVER["REMOTE_ADDR"];

$request_method=$_SERVER["REQUEST_METHOD"]; 

if($request_method == 'POST')
{
	if($signature=='naAMjzpnyLKt4B3QLWCW8lRA7D+aqJ/jWqhT2mI40vw='){
				$noAntrian=$_POST['no_antrian'];
			    $status=$_POST['status'];

				$tampil=pg_query($dbconn,"SELECT * FROM lab_analysis_kategori_harga_unit WHERE id_unit='$id_unit' AND id_kategori_harga='$id_penjamin'");
				while($r=pg_fetch_array($tampil)){
					$a=pg_fetch_array(pg_query($dbconn,"SELECT nama, persyaratan FROM lab_analysis WHERE id='$r[id_lab_analysis]'"));
					$item[] = array(
						"id"			=> $r['id_lab_analysis'],
						"nama"			=> $a['nama'],
						"harga"			=> $r['harga'],
						"persyaratan"	=> $a['persyaratan']
					);
				}
				
				
				$tampil=pg_query($dbconn,"SELECT * FROM lab_analysis_group_unit WHERE id_unit='$id_unit' AND id_group='$id_penjamin'");
				while($r=pg_fetch_array($tampil)){
					$a=pg_fetch_array(pg_query($dbconn,"SELECT nama, persyaratan FROM lab_analysis_group WHERE id='$r[id_lab_analysis_group]'"));
					$item2[] = array(
						"id"			=> $r['id_lab_analysis_group'],
						"nama"			=> $a['nama'],
						"harga"			=> $r['harga'],
						"persyaratan"	=> $a['persyaratan']
					);
				}
				
				$tampil=pg_query($dbconn,"SELECT * FROM lab_analysis_paket_unit WHERE id_unit='$id_unit' AND id_paket='$id_penjamin'");
				while($r=pg_fetch_array($tampil)){
					$a=pg_fetch_array(pg_query($dbconn,"SELECT nama, persyaratan FROM lab_analysis_paket WHERE id='$r[id_lab_analysis_paket]'"));
					$item3[] = array(
						"id"			=> $r['id_lab_analysis_paket'],
						"nama"			=> $a['nama'],
						"harga"			=> $r['harga'],
						"persyaratan"	=> $a['persyaratan']
					);
				}
				
				$json = array(
					'response'		=> 'success',
					'id_klinik'		=> $id_unit,
					'id_penjamin' 	=> $id_penjamin,
					'single_test'	=> $item,
					'multi_test'	=> $item2,
					'paket'			=> $item3
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