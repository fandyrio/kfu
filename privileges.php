<?php
$user=pg_query($dbconn,"SELECT id_level FROM auth_users WHERE id_users='".$_SESSION['login_user']."' ");
		$r=pg_fetch_array($user);

		
 $result=pg_query($dbconn,"SELECT id, id_menu FROM auth_akses_menu WHERE id_level= '".$r['id_level']."'");

 //definition menu
 	 $Pemanggilan_Antrian=false;
	 $Pendaftaran =false;
	 $Antrian 	  =false;
	 $Info_Pasien 	=false;
	 $Kunjungan_Pasien =false;
	 $Perhatian 		  =false;
	 $Keluhan		  =false;
	 $Anamnesa 	  =false;
	 $Gambar	  =false;
	 $Form_Pemeriksaan =false;
	 $AmbilGambar=false;
	 $PemeriksaanFisik=false;
	 $PemeriksaanMata=false;
	 $PemeriksaanTht=false;
	 $PemeriksaanMulut=false;
	 $PemeriksaanLeher=false;
	 $Thorax=false;
	 $Abdomen=false;
	 $Rektal=false;
	 $Extremitas=false;
	 $Neurologis=false;
	 $PemeriksaanKulit =false;	
	$PemeriksaanLainnya=false;	
	$Lab_Order =false;
	$Diagnosa =false;	
	$DiagnosaIcpc=false;	
	$CatatResep	=false;
	$Resume	= false;
	$TindakLanjut =false;
	$Billing =false;
	$Keuangan	= false;
	$Rujukan = false;
	$RujukanDiterima =false;
	$ReportList =false;	
	$Pegawai = false;	
	$AlatBantu =false;


	


 while ($row =pg_fetch_assoc($result)){
 	if($row['id_menu']==1 ){
 		$Pemanggilan_Antrian=true;
 	}
 	elseif($row['id_menu']==2 ){
 		$Pendaftaran=true;
 	}
 	elseif($row['id_menu']==3 ){
 		$Antrian=true;
 	}
 	elseif($row['id_menu']==4 ){
 		$Info_Pasien=true;
 	}
 	elseif($row['id_menu']==5 ){
 		$Kunjungan_Pasien=true;
 	}
 	elseif($row['id_menu']==6 ){
 		$Perhatian=true;
 	}
 	elseif($row['id_menu']==7 ){
 		$Keluhan=true;
 	}
 	elseif($row['id_menu']==8 ){
 		$Anamnesa=true;
 	}
 	elseif($row['id_menu']==9 ){
 		$Gambar=true;
 	}
 	elseif($row['id_menu']==10 ){
 		$Form_Pemeriksaan=true;
 	}
 	elseif($row['id_menu']==11 ){
 		$AmbilGambar=true;
 	}
 	elseif($row['id_menu']==12 ){
 		$PemeriksaanFisik=true;
 	}
 	elseif($row['id_menu']==13 ){
 		$PemeriksaanMata=true;
 	}
 	elseif($row['id_menu']==14 ){
 		$PemeriksaanTht=true;
 	}
 	elseif($row['id_menu']==15 ){
 		$PemeriksaanMulut=true;
 	}
 	elseif($row['id_menu']==16 ){
 		$PemeriksaanLeher=true;
 	}
 	elseif($row['id_menu']==17 ){
 		$Thorax=true;
 	}
 	elseif($row['id_menu']==18 ){
 		$Abdomen=true;
 	}
 	elseif($row['id_menu']==19 ){
 		$Rektal=true;
 	}
 	elseif($row['id_menu']==20 ){
 		$Extremitas=true;
 	}
 	elseif($row['id_menu']==21 ){
 		$Neurologis=true;
 	}
 	elseif($row['id_menu']==22 ){
 		$PemeriksaanKulit=true;
 	}
 	elseif($row['id_menu']==23 ){
 		$PemeriksaanLainnya=true;
 	}
 	elseif($row['id_menu']==24 ){
 		$Lab_Order=true;
 	}
 	elseif($row['id_menu']==25 ){
 		$Diagnosa=true;
 	}
 	elseif($row['id_menu']==26 ){
 		$DiagnosaIcpc=true;
 	}
 	elseif($row['id_menu']==27 ){
 		$CatatResep=true;
 	}
 	elseif($row['id_menu']==28 ){
 		$Resume=true;
 	}
 	elseif($row['id_menu']==29 ){
 		$TindakLanjut=true;
 	}
 	elseif($row['id_menu']==30 ){
 		$Billing=true;
 	}
 	elseif($row['id_menu']==31 ){
 		$Keuangan=true;
 	}
 	elseif($row['id_menu']==32 ){
 		$Rujukan=true;
 	}elseif($row['id_menu']==33 ){
 		$RujukanDiterima=true;
 	
 	}elseif($row['id_menu']==34 ){
 		$ReportList=true;
 	
 	}elseif($row['id_menu']==35 ){
 		$Pegawai=true;
 	
 	}elseif($row['id_menu']==36 ){
 		$AlatBantu=true;
 	}
 	
 	
 }

/*require_once("config/whoami.php");
$cipher = new ark_stalker(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
 
$kunci = "WHOAMI";
$string=$setting['nama'];;
 
$en = $cipher->encrypt($string, $kunci);
$de = $cipher->decrypt($en, $kunci);


if( $en !='2b3p69JegNhi7C6FdcR3MA=='){
die;
}
*/
		
 ?>