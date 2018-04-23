<?php 
$cek_nama_brand = pg_query($dbconn,"SELECT id FROM inv_inventori WHERE id_brand ='$_POST[brand]' ");
$cek =pg_num_rows($cek_nama_brand);


if($cek){
	echo "NAMA BRAND SUDAH DIGUNAKAN";
}

?>