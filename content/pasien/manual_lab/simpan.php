<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/library.php";
include "../../../config/fungsi_tanggal.php";


$query=pg_query($dbconn,"INSERT INTO pasien_manual_lab (
	id_pasien, 
	id_kunjungan, 
	hasil,  
	nama_tindakan, 
	nilai_normal, 
	tgl_input, 
	satuan,
	high_mark, 
	id_users, 
	id_unit
	) 
	VALUES
	 (
	 '$_POST[id_pasien]',
	  '$_POST[id_kunjungan]',
	   '$_POST[hasil]',  
	   '$_POST[nama_tindakan]', 
	   '$_POST[nilai_normal]', 
	   '$tgl_sekarang $jam_sekarang', 
	   '$_POST[satuan]',
	   '$_POST[status]',
	   '$_SESSION[login_user]', 
	   '$_SESSION[id_units]')
	 ");

if($query){
	echo "success";


}
else{
	echo "gagal";

}

?>
