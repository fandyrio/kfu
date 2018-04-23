<?php
$user=pg_query($dbconn,"SELECT id_level FROM auth_users WHERE id_users='".$_SESSION['login_user']."' ");
		$r=pg_fetch_array($user);

		
 $result=pg_query($dbconn,"SELECT id, id_menu FROM auth_akses_menu WHERE id_level= '".$r['id_level']."'");

 //definition menu
	 $Pendaftaran =false;
	 $Antrian 	  =false;
	 $Info_Pasien =false;
	$Kunjungan_Pasien =false;
	$Perhatian 		  =false;
	$Peringatan 	  =false;
	$Order_Paket =false;
	$Lab_Order =false;
	$Hasil_Lab =false;
	$Radiologi =false;
	$Pengukuran =false;
	$Pengambilan_Bahan =false;
	$Billing =false;


	 //$Keuangan 	= false;
	 $inventori = false;
	 $supplier 	= false;
	 $stok      = false;
	 $lab_tracking = false;
	 $report_list  = false;
	 $klaim    = false;

	$Invoice = false;
	$Pembayaran= false;

	$Terima_Barang =false;
	$po= false;
	$penawaran_harga= false;
	$permintaan_penawaran=false;
	$pengembalian_barang=false;
	$stok_adj=false;
	$stok_saat=false;
	$stok_movement=false;
	$stok_mutasi=false;
	$menu_order= false;
	$menu_hasil=false;
	$Jenis_Pemeriksaan=false;
	$Data_Pasien=false;
	$Laporan_Rawat_Jalan=false;
	$Import_Data_Pasien=false;



 while ($row =pg_fetch_assoc($result)){
 	if($row['id_menu']==1 ){
 		$Pendaftaran=true;
 	}
 	elseif($row['id_menu']==2 ){
 		$Antrian=true;
 	}
 	elseif($row['id_menu']==3 ){
 		$Info_Pasien=true;
 	}
 	elseif($row['id_menu']==4 ){
 		$Kunjungan_Pasien=true;
 	}
 	elseif($row['id_menu']==5 ){
 		$Perhatian=true;
 	}
 	elseif($row['id_menu']==6 ){
 		$Peringatan=true;
 	}
 	elseif($row['id_menu']==7 ){
 		$Order_Paket=true;
 	}
 	elseif($row['id_menu']==8 ){
 		$Lab_Order=true;
 	}
 	elseif($row['id_menu']==9 ){
 		$Hasil_Lab=true;
 	}
 	elseif($row['id_menu']==10 ){
 		$Radiologi=true;
 	}
 	elseif($row['id_menu']==11 ){
 		$Pengukuran=true;
 	}
 	elseif($row['id_menu']==12 ){
 		$Pengambilan_Bahan=true;
 	}
 	elseif($row['id_menu']==13 ){
 		$Billing=true;
 	}
 	elseif($row['id_menu']==14 ){
 		$klaim=true;
 	}
 	elseif($row['id_menu']==15 ){
 		$Invoice=true;
 	}
 	elseif($row['id_menu']==16 ){
 		$Keuangan=true;
 	}
 	elseif($row['id_menu']==17 ){
 		$Pembayaran=true;
 	}
 	elseif($row['id_menu']==18 ){
 		$Terima_Barang=true;
 	}
 	elseif($row['id_menu']==19 ){
 		$po=true;
 	}
 	elseif($row['id_menu']==20 ){
 		$penawaran_harga=true;
 	}
 	elseif($row['id_menu']==21 ){
 		$permintaan_penawaran=true;
 	}
 	elseif($row['id_menu']==22 ){
 		$pengembalian_barang=true;
 	}
 	elseif($row['id_menu']==23 ){
 		$stok_adj=true;
 	}
 	elseif($row['id_menu']==24 ){
 		$stok_saat=true;
 	}
 	elseif($row['id_menu']==25 ){
 		$stok_movement=true;
 	}
 	elseif($row['id_menu']==26 ){
 		$stok_mutasi=true;
 	}
 	elseif($row['id_menu']==27 ){
 		$menu_oorder=true;
 	}
 	elseif($row['id_menu']==28 ){
 		$menu_hasil=true;
 	}
 	elseif($row['id_menu']==29 ){
 		$Jenis_Pemeriksaan=true;
 	}
 	elseif($row['id_menu']==30 ){
 		$Data_Pasien=true;
 	}

 	elseif($row['id_menu']==31 ){
 		$Laporan_Rawat_Jalan=true;
 	}elseif($row['id_menu']==32 ){
 		$Import_Data_Pasien=true;
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