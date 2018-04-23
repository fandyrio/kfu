<?php
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		$id_kategori_harga = $_POST['id_kategori_harga'];
		$keterangan = $_POST['keterangan'];
		$id = $_POST['id'];
		
		date_default_timezone_set("Asia/Jakarta");
		$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");

		
		$result=pg_query($dbconn,"UPDATE pasien_order SET catatan='$keterangan' WHERE id='$id' ");
		$delete=pg_query($dbconn,"DELETE from transaksi_invoice_detail WHERE id_pasien_order='$id' ");
		
		

		if (!isset($_POST['checkbox_non_lab']) || empty($_POST['checkbox_non_lab'])) {
				  
		} 
		else{
			$checkbox_non_lab =array_values($_POST['checkbox_non_lab']);

			$arrlength = sizeof($checkbox_non_lab);
			$total_nett =0;

			for( $i=0; $i<$arrlength; $i++){
				 $pieces_t = explode("_", $checkbox_non_lab[$i]);

				pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien_order, id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) 
					VALUES ('$id','$_POST[id_pasien]', '$_POST[id_kunjungan]', 'N', '$pieces_t[1]', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$pieces_t[0]', '1', 'N', '$_SESSION[id_units]')");
				 $total_nett += $pieces_t[1];	
			}				
		}	
		if (!isset($_POST['checkbox_single_test']) || empty($_POST['checkbox_single_test'])) {
				  
		} 
		else{

			$check1 =array_values($_POST['checkbox_single_test']);
			$arrlength1 = sizeof($check1);
			$total_nett1 =0;

			var_dump($check1);

			for( $j=0; $j<$arrlength1; $j++){
			$pieces_l = explode("_", $check1[$j]);	
			pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien_order, id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) 
					VALUES ('$id','$_POST[id_pasien]', '$_POST[id_kunjungan]', 'S', '$pieces_l[1]', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$pieces_l[0]', '1', 'N', '$_SESSION[id_units]')");
			  $total_nett1 += $pieces_l[1];		
			}
		}

		if (!isset($_POST['checkbox_multiple_test']) || empty($_POST['checkbox_multiple_test'])) {
				  
		}
		else{
			$check2 =array_values($_POST['checkbox_multiple_test']);
			$arrlength2 = sizeof($check2);
			$total_nett2 =0;


			for( $k=0; $k<$arrlength2; $k++){
			$pieces_m = explode("_", $check2[$k]);	
			pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien_order, id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) 
					VALUES ('$id','$_POST[id_pasien]', '$_POST[id_kunjungan]', 'M', '$pieces_m[1]', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$pieces_m[0]', '1', 'N', '$_SESSION[id_units]')");
			  $total_nett2 += $pieces_m[1];

			}			
		}
		if (!isset($_POST['checkbox_mcu']) || empty($_POST['checkbox_mcu'])) {
				  
		} 
		else{

			$check3 =array_values($_POST['checkbox_mcu']);
			$arrlength3 = sizeof($check3);
			$total_nett3 =0;

			for( $l=0; $l<$arrlength3; $l++){
			 $pieces_e= explode("_", $check3[$l]);	

				pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien_order, id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) 
					VALUES ('$id','$_POST[id_pasien]', '$_POST[id_kunjungan]', 'E', '$pieces_e[1]', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$pieces_e[0]', '1', 'N', '$_SESSION[id_units]')");
			  $total_nett3 += $pieces_e[1];		  
			}
		}
			$harga_total_paket = 0;
			$harga_total_paket =  $total_nett1 + $total_nett+ $total_nett2 + $total_nett3;

		pg_query($dbconn,"UPDATE pasien_order SET total='$harga_total_paket' WHERE id='$id'");


?>
