<?php
include "../../../../config/conn.php";
session_start();
error_reporting(0);

			$harga='0';
			if($_POST['jenis']=='S'){
				$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_kategori_harga_unit
				 WHERE id_lab_analysis='$_POST[id_detail]' and id_unit='$_SESSION[id_units]' and id_kategori_harga='$_POST[id_kategori_harga]'"));

				$harga=$a[harga];	

												
				}						
			elseif($_POST['jenis']=='E'){
									
				$a=pg_query($dbconn,"SELECT * FROM billing_paket_kategori_harga_unit  WHERE id_billing_paket='$_POST[id_detail]' and id_kategori_harga='$_POST[id_kategori_harga]' and id_unit='$_SESSION[id_units]' ");
		
				$harga="$a[harga]";
				}
										
			
			elseif($_POST['jenis']=='M'){
				$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group_unit WHERE id_lab_analysis_group='$_POST[id_detail]' and id_kategori_harga='$_POST[id_kategori_harga]' and id_unit='$_SESSION[id_units]' "));
				$harga="$a[harga]";
											
				}
			elseif($_POST['jenis']=='N'){
				$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan_kategori_harga_unit WHERE id_tindakan='$_POST[id_detail]' and id_kategori_harga='$_POST[id_kategori_harga]' and id_unit='$_SESSION[id_units]'"));
				$harga="$a[harga]";
											
				}
			
				echo $harga;			
								
		


?>
	