<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Jakarta");
include "constanta.php";
include "config/conn.php";
include "config/library.php";
//include "config/fungsi_tanggal.php";
$id_unit=$_SESSION['id_units'];
var_dump($id_unit);

$getIdOutlet=pg_query("SELECT * from master_unit where id='$id_unit'");
$fetchUnit=pg_fetch_assoc($getIdOutlet);
$idOutlet=$fetchUnit['id_outlet'];
$kode=$fetchUnit['kode'];



//echo $post_data;
//		echo '<br>' . config_item('api_url') . $url;
		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
$getTimeRecord=pg_query("SELECT * from record_hit_api_reservation");
$jumlah=pg_num_rows($getTimeRecord);
$today=date("Y-m-d");
$since=$today."T00:00:00.000Z";
	
	$insertTimeRecord=pg_query("INSERT into record_hit_api_reservation (time,date) values (NOW(), NOW())");
	$url=API_GET_ALL_RESERVE.$since;

	$updateTimeRecord=pg_query("UPDATE record_hit_api_reservation set time=NOW() ,date=NOW()");

	//var_dump($url);


		


 
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


		//Get Maximum Nomor Antrian
		$q=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_antrian) AS no_antrian FROM antrian WHERE id_unit='$_SESSION[id_units]'"));
		$no_antrian=$q['no_antrian'];


		$tahun = $thn_sekarang;
		$bulan = $bln_sekarang;
		$tanggal = $tgl_skrg;
		$thn = substr($tahun,-2);


		$tglBefore=substr($no_antrian,6,6);

		$tglNow = $thn.$bulan.$tanggal;
		if($tglNow==$tglBefore){
			$urut_before = substr($no_antrian,12,3);//228
			$urut_before++;
				
			$no_antrian_new = $kode.$tglNow.sprintf("%03s",$urut_before);		
		}
		else
		{
			$no_antrian_new = $kode.$tglNow.sprintf("%03s",1);	
		}

		//=============================================
		//Get Max Antiran from antrian_reservasi
		$antrianUnit=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_antrian) AS no_antrian FROM antrian_reservasi WHERE id_unit='$_SESSION[id_units]'"));
		$no_antrian_unit=$antrianUnit['no_antrian'];


		$tahun = $thn_sekarang;
		$bulan = $bln_sekarang;
		$tanggal = $tgl_skrg;
		$thn = substr($tahun,-2);


		$tglBefore=substr($no_antrian_unit,6,6);

		$tglNow = $thn.$bulan.$tanggal;
		if($tglNow==$tglBefore){
			$urut_before = substr($no_antrian_unit,12,3);//228
			$urut_before++;
				
			$no_antrian_reservasi_new = $kode.$tglNow.sprintf("%03s",$urut_before);		
		}
		else
		{
			$no_antrian_reservasi_new = $kode.$tglNow.sprintf("%03s",1);	
		}

		/*for($x=1;$x<=5;$x++)
		{
			var_dump($no_antrian_reservasi_new);
			$no_antrian_reservasi_new++;echo"<br />";
		}*/

		//==============================================

		if($no_antrian_new == $no_antrian_reservasi_new)
		{
			$antrianReservasi=$no_antrian_reservasi_new;
		}
		else if($no_antrian_new > $no_antrian_reservasi_new)
		{
			$antrianReservasi=$no_antrian_new++;
		}
		else if($no_antrian_new < $no_antrian_reservasi_new)
		{
			$antrianReservasi=$no_antrian_reservasi_new++;
		}
//		var_dump($antrianReservasi);

		$namaFile="data/csv/csv-".$fetchUnit['id'].'.csv';
		//var_dump(fopen($namaFile, "w"));

		$fp = fopen($namaFile, 'a+');
if ( !$fp ) {
  echo 'last error: ';
 // var_dump(error_get_last());
}
else {
  //echo "ok.\n";
}

		$myfile = fopen($namaFile, "w") or die("Unable to open file!");
		fwrite($myfile, $return);
		fclose($myfile);

		$row = 1;
		if (($handle = fopen($namaFile, "r")) !== FALSE) {
  			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
  			{
	    		$num = count($data);
	    		$row++;
	    		if($data[1]!='reservationId')
	    		{
	    			

	    			$getExistedDetail=pg_query("SELECT * from antrian_reservasi where id_reservasi='$data[1]'");
	    			$jumlahExistedDetail=pg_num_rows($getExistedDetail);
	    		
	    				/*while($fetchData=pg_fetch_assoc($getExistedData))
	    				{	
		    				if($fetchData['id_reservasi']!=$data[1])
		    				{
			    				$insertNoAntrian=pg_query("INSERT into antrian_reservasi (id_reservasi,no_antrian,id_unit)
			    				VALUES ('$data[1]','$antrianReservasi','$_SESSION[id_units]')");
		    				}
		    					
	    				}*/
	    				if($jumlahExistedDetail==0)
	    				{
	    					$insertNoAntrian=pg_query("INSERT into antrian_reservasi (id_reservasi,no_antrian,id_unit)
			    				VALUES ('$data[1]','$antrianReservasi','$_SESSION[id_units]')");
			    				$antrianReservasi++;
			    				var_dump("INSERT into antrian_reservasi (id_reservasi,no_antrian,id_unit)
			    				VALUES ('$data[1]','$antrianReservasi','$_SESSION[id_units]')");
	    				}
	    				else
	    				{
	    					echo "a";
	    				}
	    			
	    			
	    		}    		
  		}
  		fclose($handle);
		}
		else
		{
			echo"False";
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

?>
<script type="text/javascript">
window.location.replace("pendaftaran");
</script>