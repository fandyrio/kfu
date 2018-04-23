<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/library.php";
include "../../../config/fungsi_tanggal.php";


$query=pg_query($dbconn,"UPDATE pasien_manual_lab 
	SET 
	hasil 			=  '$_POST[hasil]',
	nama_tindakan	= '$_POST[nama_tindakan]', 
	nilai_normal	= '$_POST[nilai_normal]', 
	satuan 			=  '$_POST[satuan]',
	high_mark		=  '$_POST[status]'
	");

if($query){
	echo "success";


}
else{
	echo "gagal";

}

?>
