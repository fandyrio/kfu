<?php
		session_start();
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		$id_kategori_harga = $_POST['id_kategori_harga'];
		$keterangan = $_POST['keterangan'];
		
		date_default_timezone_set("Asia/Jakarta");
		$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");

		$invo ="";
/*
		//FIND DOKTER FROM ANTRIAN
		$query_dokter="SELECT id_dokter FROM antrian WHERE id_pasien='$id_pasien' AND id_kunjungan ='$id_kunjungan'";
		$d_dokter=pg_fetch_array(pg_query($query_dokter));
		$id_dokter=$d_dokter['id_dokter'];*/
		//////////////////////////////////////////////////

		$hasil = pg_query($dbconn,"SELECT * FROM transaksi_invoice where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit='$_SESSION[id_units]' and status_issue is NULL ");

		/*var_dump("SELECT * FROM transaksi_invoice where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit='$_SESSION[id_units]' and status_issue is NULL");
*/

		$jlh = pg_num_rows($hasil);
		if($jlh>0 )
		{
			$t_inv= pg_fetch_array($hasil);
			$invo= $t_inv[id]; 

		}else{

			$unit=pg_fetch_array(pg_query($dbconn,"SELECT kode FROM master_unit WHERE id='$_SESSION[id_units]'"));

			$kode=$unit['kode'];

			$d=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_invoice) AS no_invoice FROM transaksi_invoice WHERE id_unit='$_SESSION[id_units]'"));

			$no_invoice=$d['no_invoice'];

			$kode_now="TX".$kode;

			$kode_before = substr($no_invoice,0,8);
			if($kode_before==$kode_now){
				$no_urut = (int) substr($no_invoice,8,5);
				$no_urut++;
				$no_invoice_new = $kode_now.sprintf("%05s",$no_urut);
			}
			else{	
				$no_invoice_new = $kode_now.sprintf("%05s",1);	
			}
				
				
				$kunj=pg_query($dbconn,"INSERT INTO transaksi_invoice (no_invoice, id_pasien, id_kunjungan, waktu_input, id_users,  status_selesai,total, sudah_bayar, id_kategori_harga_bayar, id_unit) VALUES ('$no_invoice_new', '$id_pasien', '$id_kunjungan', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]',  'N','0' ,'0', '$id_kategori_harga', '$_SESSION[id_units]') RETURNING id");


				$k = pg_fetch_row($kunj);
				$invo = $k[0];
			}

		// $result=pg_query($dbconn,"INSERT INTO pasien_order (catatan, waktu_input, id_user, id_pasien, id_unit, id_kunjungan)
		// 	VALUES ('$_POST[keterangan]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_pasien]', '$_SESSION[id_units]', '$_POST[id_kunjungan]') RETURNING id");
		
		// //$insert_row = pg_fetch_row($result);
		// //$insert_id = $insert_row[0];

		if (!isset($_POST['checkbox_non_lab']) || empty($_POST['checkbox_non_lab'])) {
				  
		} 
		else{
			$checkbox_non_lab =array_values($_POST['checkbox_non_lab']);

			$arrlength = sizeof($checkbox_non_lab);
			$total_nett =0;

			for( $i=0; $i<$arrlength; $i++){
				 $pieces_t = explode("_", $checkbox_non_lab[$i]);
				// $BERAPA  = $FIND_FEE($id_dokter, $pieces_t[0]);
				$invo_detail=pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_invoice,  id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) 
					VALUES ('$invo','$_POST[id_pasien]', 
					'$_POST[id_kunjungan]', 'N', '$pieces_t[1]', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$pieces_t[0]', '1', 'N', '$_SESSION[id_units]' ) RETURNING id");
				  $total_nett += $pieces_t[1];	

			  $inv = pg_fetch_row($invo_detail);

			  pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$inv[0]', '$pieces_t[0]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$id_pasien','$id_kunjungan', 'N', '1','1' )");
			}				
		}	
		if (!isset($_POST['checkbox_single_test']) || empty($_POST['checkbox_single_test'])) {
				  
		} 
		else{

			$check1 =array_values($_POST['checkbox_single_test']);
			$arrlength1 = sizeof($check1);
			$total_nett1 =0;
			
			for( $j=0; $j<$arrlength1; $j++){
				 $pieces_l = explode("_", $check1[$j]);			
			$invo_detail= pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_invoice, id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) 
					VALUES ('$invo','$_POST[id_pasien]', '$_POST[id_kunjungan]', 'S', '$pieces_l[1]', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$pieces_l[0]', '1', 'N', '$_SESSION[id_units]') RETURNING id");

			$total_nett1 += $pieces_l[1];		

			$inv = pg_fetch_row($invo_detail);

			 pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$inv[0]', '$pieces_l[0]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$id_pasien','$id_kunjungan', 'S', '1','1' )");
			}
		}


		$harga_total_paket = 0;
		$harga_total_paket =  $total_nett1 + $total_nett+ $total_nett2 + $total_nett3;

		//pg_query($dbconn,"UPDATE transaksi_invoice SET total=total+'$harga_total_paket' WHERE id='$invo'");

		
		//pg_query($dbconn,"UPDATE transaksi_invoice_detail SET status_order='1' WHERE id_pasien_order='$insert_id'");


/*function  FIND_FEE ($ID_DOKTER, $ID_TINDAKAN) {
	global $dbconn;
	$query="SELECT persen_dokter, harga FROM tindakan_dokter_unit WHERE id_karyawan='$ID_DOKTER' AND id_unit='$_SESSION[id_units]' AND id_tindakan='$ID_TINDAKAN'";
	$data_fee= pg_fetch_array(pg_query($dbconn,$query));
	$FEE_DOKTER=0;
	$fee 	= $data_fee['persen_dokter'];
	$harga 	= $data_fee['harga'];
	if($fee){
		$FEE_DOKTER = $fee * $harga / 100;
	}
	else{
		$FEE_DOKTER=0;
	}
	 return $FEE_DOKTER;
}*/

?>
