<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
include "../../config/conn.php";
include "../../config/library.php";
include "../../config/fungsi_tanggal.php";
include "../../config/fungsi_thumb.php";

$module=$_GET['module'];
$act=$_GET['act'];
if ($module=='pasien' AND $act=='delete'){
	pg_query($dbconn,"UPDATE master_pasien SET status_hapus='Y' WHERE id='$_GET[id]'");
	
	header("location:pasien");
}

elseif($module=='pasien' AND $act=='update'){
	
	$tanggal_lahir=DateToEng($_POST['tanggal_lahir']);
		
	$acak			 = rand(1,99);
	$lokasi_file     = $_FILES['fupload']['tmp_name'];
	$tipe_file       = $_FILES['fupload']['type'];
	$nama_file       = $_FILES['fupload']['name'];
	$nama_file_unik  = $acak.$nama_file;
	
	if ($_FILES["fupload"]["error"] > 0 OR empty($lokasi_file)){
		$nama_file_unik = "$_POST[foto]";
	}
  
	else{
		UploadPasien($nama_file_unik);
		unlink("../../images/pasien/upload_$_POST[foto]");
	}
	if($_POST['id_jenis_pasien']==1){	
		pg_query($dbconn,"UPDATE master_pasien SET nik='$_POST[nik]', nama='$_POST[nama]', id_title='$_POST[id_title]', id_lainnya='$_POST[id_lainnya]', tanggal_lahir='$tanggal_lahir', jenkel='$_POST[jenkel]', no_telepon='$_POST[no_telepon]', no_handphone='$_POST[no_handphone]', email='$_POST[email]', no_telepon_kerja='$_POST[no_telepon_kerja]', id_goldar='$_POST[id_goldar]', id_status_kawin='$_POST[id_status_kawin]', id_suku='$_POST[id_suku]', id_pekerjaan='$_POST[id_pekerjaan]', id_provinsi='$_POST[id_provinsi]', id_kabupaten='$_POST[id_kabupaten]', id_kecamatan='$_POST[id_kecamatan]', id_kelurahan='$_POST[id_kelurahan]', alamat='$_POST[alamat]', tanggal_edit='$tgl_sekarang', jam_edit='$jam_sekarang', foto='$nama_file_unik', tempat_lahir='$_POST[tempat_lahir]', id_warga_negara='$_POST[id_warga_negara]', id_kategori_pasien='$_POST[id_kategori_pasien]', id_bahasa='$_POST[id_bahasa]', id_agama='$_POST[id_agama]', id_jenis_pasien='$_POST[id_jenis_pasien]' WHERE id='$_POST[id_pasien]'");
	}
	elseif($_POST['id_jenis_pasien']==2){
		pg_query($dbconn,"UPDATE master_pasien SET no_bpjs='$_POST[no_bpjs]', nik='$_POST[nik]', nama='$_POST[nama]', id_title='$_POST[id_title]', id_lainnya='$_POST[id_lainnya]', tanggal_lahir='$tanggal_lahir', jenkel='$_POST[jenkel]', no_telepon='$_POST[no_telepon]', no_handphone='$_POST[no_handphone]', email='$_POST[email]', no_telepon_kerja='$_POST[no_telepon_kerja]', id_goldar='$_POST[id_goldar]', id_status_kawin='$_POST[id_status_kawin]', id_suku='$_POST[id_suku]', id_pekerjaan='$_POST[id_pekerjaan]', id_provinsi='$_POST[id_provinsi]', id_kabupaten='$_POST[id_kabupaten]', id_kecamatan='$_POST[id_kecamatan]', id_kelurahan='$_POST[id_kelurahan]', alamat='$_POST[alamat]', tanggal_edit='$tgl_sekarang', jam_edit='$jam_sekarang', foto='$nama_file_unik', tempat_lahir='$_POST[tempat_lahir]', id_warga_negara='$_POST[id_warga_negara]', id_kategori_pasien='$_POST[id_kategori_pasien]', id_bahasa='$_POST[id_bahasa]', id_agama='$_POST[id_agama]', id_jenis_pasien='$_POST[id_jenis_pasien]' WHERE id='$_POST[id_pasien]'");
	}
	
	elseif($_POST['id_jenis_pasien']>=3){
		pg_query($dbconn,"UPDATE master_pasien SET nik='$_POST[nik]', nama='$_POST[nama]', id_title='$_POST[id_title]', id_lainnya='$_POST[id_lainnya]', tanggal_lahir='$tanggal_lahir', jenkel='$_POST[jenkel]', no_telepon='$_POST[no_telepon]', no_handphone='$_POST[no_handphone]', email='$_POST[email]', no_telepon_kerja='$_POST[no_telepon_kerja]', id_goldar='$_POST[id_goldar]', id_status_kawin='$_POST[id_status_kawin]', id_suku='$_POST[id_suku]', id_pekerjaan='$_POST[id_pekerjaan]', id_provinsi='$_POST[id_provinsi]', id_kabupaten='$_POST[id_kabupaten]', id_kecamatan='$_POST[id_kecamatan]', id_kelurahan='$_POST[id_kelurahan]', alamat='$_POST[alamat]', tanggal_edit='$tgl_sekarang', jam_edit='$jam_sekarang', foto='$nama_file_unik', tempat_lahir='$_POST[tempat_lahir]', id_warga_negara='$_POST[id_warga_negara]', id_kategori_pasien='$_POST[id_kategori_pasien]', id_bahasa='$_POST[id_bahasa]', id_agama='$_POST[id_agama]', id_jenis_pasien='$_POST[id_jenis_pasien]' WHERE id='$_POST[id_pasien]'");
	}
	//pg_query($dbconn, "UPDATE master_pasien_keluarga SET id_pasien='$_POST[id_pasien]', id_session='' WHERE id_session='$_SESSION[id_session]'");
	//pg_query($dbconn, "UPDATE master_pasien_penjamin SET id_pasien='$_POST[id_pasien]', id_session='' WHERE id_session='$_SESSION[id_session]'");
	header("location:pasien");
}

pg_close($dbconn);
}
?>