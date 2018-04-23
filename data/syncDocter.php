<?php
session_start();
include "constanta.php";
include "../config/conn.php";
$idDokter=$_GET['idDokter'];

	$id_unit=$_SESSION['id_units'];

	$getIdOutlet=pg_query("SELECT * from master_unit where id='$id_unit'");
	$fetchUnit=pg_fetch_assoc($getIdOutlet);
	$idOutlet=$fetchUnit['id_outlet'];

//echo $post_data;
//		echo '<br>' . config_item('api_url') . $url;
		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		$url=API_DOCTOR.$idDokter;


			$header = array(
            'Content-Type:application/json',
			'X-Auth-OutletId:'.$idOutlet,
			'X-Auth-Token:p7riBrL1PGOKtDveaymsl2LZvWiQYDQJltan96bj',
			'X-Auth-BvkUserId:1');
 
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
		//print_r($data['id']);
		//print_r($header);
		$id_dokter=$data['id'];
		$getInformationDoctor=pg_query($dbconn,"SELECT count(*) as jumlah from master_karyawan where id='$id_dokter'");
		$jlhData=pg_fetch_array($getInformationDoctor);

		//gender convert
		if($data['gender']=="FEMALE")
		{
			$jk=1;
		}
		else
		{
			$jk=2;
		}
		//print_r($jlhData['jumlah']);
		if($jlhData['jumlah']==0)
		{
			$contract_start=$data['contract']['start'];
			$contract_end=$data['contract']['end'];
			$insertData=pg_query($dbconn, "INSERT into master_karyawan(id, id_klinik, id_poly,tanggal_lahir,id_jenkel,email, telepon,start_contract,end_contract, nama,id_jabatan)
											values('$data[id]', '$data[clinicId]','$data[polyId]','$data[birthDate]','$jk','$data[email]','$data[phone]','$contract_start','$contract_end','$data[name]','1')");
			$getDays=pg_query($dbconn, "SELECT * from master_hari");
			while($listDays=pg_fetch_assoc($getDays))
			{
				if($listDays['id']==1)
				{
					$start=$data['schedule'][0]['sunday'][0]['start'];
					$end=$data['schedule'][0]['sunday'][0]['end'];
				}
				else if($listDays['id']==2)
				{
					$start=$data['schedule'][0]['monday'][0]['start'];
					$end=$data['schedule'][0]['monday'][0]['end'];
				}
				else if($listDays['id']==3)
				{
					$start=$data['schedule'][0]['tuesday'][0]['start'];
					$end=$data['schedule'][0]['tuesday'][0]['end'];
				}
				else if($listDays['id']==4)
				{
					$start=$data['schedule'][0]['wednesday'][0]['start'];
					$end=$data['schedule'][0]['wednesday'][0]['end'];
				}
				else if($listDays['id']==5)
				{
					$start=$data['schedule'][0]['thursday'][0]['start'];
					$end=$data['schedule'][0]['thursday'][0]['end'];
				}
				else if($listDays['id']==6)
				{
					$start=$data['schedule'][0]['friday'][0]['start'];
					$end=$data['schedule'][0]['friday'][0]['end'];
				}
				else if($listDays['id']==7)
				{
					$start=$data['schedule'][0]['saturday'][0]['start'];
					$end=$data['schedule'][0]['saturday'][0]['end'];
				}
				$validFrom=$data['schedule'][0]['validFrom'];
				$insertJadwal=pg_query($dbconn, "INSERT into master_jadwal_dokter(id_dokter,start_hours,end_hours,valid_from,id_hari)
												values('$data[id]','$start','$end','$validFrom', '$listDays[id]')");	
			}
			
			
			
		}
		
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

		$reservasi=$_GET['idReservasi'];

		$explode=explode(":", $reservasi);

		$idReservasi=$explode[1];
		$getDataReservasi=pg_query("SELECT * from antrian_reservasi where id_reservasi='$idReservasi'");
		$fetchReservasi=pg_fetch_assoc($getDataReservasi);
		echo $fetchReservasi['no_antrian'];
?>