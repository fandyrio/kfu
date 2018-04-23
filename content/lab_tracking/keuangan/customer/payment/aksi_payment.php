<?php
session_start();
//error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../../config/conn.php";
	include "../../../../config/library.php";

	$module=$_GET['module'];
	$act=$_GET['act'];
	
	if ($module=='keuangan_customer_payment' AND $act=='input'){

		$q=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_payment) AS no_payment FROM transaksi_payment"));
		$no_payment=$q['no_payment'];
		$kode_before = substr($no_payment,2,6);
		$tahun = $thn_sekarang;
		$bulan = $bln_sekarang;
		$tanggal = $tgl_skrg;

		$thn = substr($tahun,-2);
		$kode_now = $thn.$bulan.$tanggal;
		if($kode_before==$kode_now){
			$no_urut = (int) substr($no_payment,8,3);
			$no_urut++;
			
			$no_payment_new = 'TP'.$kode_before.sprintf("%03s",$no_urut);
		}
		else{
			$no_payment_new = 'TP'.$kode_now.sprintf("%03s",1);
		}

		/*$distc=pg_query($dbconn,"SELECT DISTINCT id_kategori_harga FROM transaksi_invoice_detail WHERE id_invoice='$_POST[id_invoice]'");
		
		while($r=pg_fetch_array($distc))
		{
		if($r['id_kategori_harga']=='1'){
		pg_query($dbconn,"INSERT INTO transaksi_payment (id_bank, id_invoice, waktu_input, jumlah_bayar, catatan, no_payment, status_hapus, nama_pembayar, id_metode_pembayaran, no_kartu, id_user, harga_invoice, dana_kembali, no_handphone, id_pasien, id_unit, id_kategori_harga) VALUES ('$_POST[id_bank]', '$_POST[id_invoice]', '$tgl_sekarang $jam_sekarang', '$_POST[jumlah_bayar]', '$_POST[catatan]', '$no_payment_new', 'N', '$_POST[nama_pembayar]', '$_POST[id_metode_bayar]', '$_POST[no_transaksi]', '$_SESSION[login_user]', '$_POST[total_bayar]', '$_POST[dana_kembali]', '$_POST[no_handphone]', '$_POST[id_pasien]', '$_SESSION[id_units]','1')");


		}else{
		pg_query($dbconn,"INSERT INTO transaksi_payment (id_bank, id_invoice, waktu_input, catatan, no_payment, status_hapus, nama_pembayar, id_user,  no_handphone, id_pasien, id_unit, id_kategori_harga) VALUES ('$_POST[id_bank]', '$_POST[id_invoice]', '$tgl_sekarang $jam_sekarang',  '$_POST[catatan]', '$no_payment_new', 'N', '$_POST[nama_pembayar]',  '$_SESSION[login_user]', '$_POST[no_handphone]', '$_POST[id_pasien]', '$_SESSION[id_units]','$r[id_kategori_harga]')");

		}

		}*/

		pg_query($dbconn,"UPDATE transaksi_invoice SET status_bayar='Y', sudah_bayar='$_POST[total_bayar]', sisa=total-'$_POST[total_bayar]'  WHERE id='$_POST[id_invoice]'");

		pg_query($dbconn,"UPDATE transaksi_payment SET nama_pembayar='$_POST[nama_pembayar]',id_metode_pembayaran='$_POST[id_metode_bayar]', jumlah_bayar='$_POST[jumlah_bayar]',id_edc='$_POST[id_edc]', dana_kembali='$_POST[dana_kembali]',no_handphone='$_POST[no_handphone]' WHERE id_invoice='$_POST[id_invoice]' and id_kategori_harga='1' and id_pasien='$_POST[id_pasien]'");


		
		header("location:keuangan-customer-payment");
		
	}
	
	elseif ($module=='keuangan_customer_payment' AND $act=='delete'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_payment WHERE no_payment='$_GET[no_payment]'"));
		pg_query($dbconn,"UPDATE transaksi_payment SET status_hapus='Y', id_user='$_SESSION[login_user]', waktu_input='$tgl_sekarang $jam_sekarang' WHERE no_payment='$_GET[no_payment]'");
		pg_query($dbconn,"UPDATE transaksi_invoice SET status_bayar='N' WHERE id='$d[id_invoice]'");
		header("location:view-keuangan-customer-payment");
	}
	
	pg_close($dbconn);
}
?>