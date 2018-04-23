<?php 

			$id_users = $_SESSION['id_users'];
			$id = $_POST['id'];
            $gender = $_POST['id_gender'];
            $dari_usia = $_POST['dari_usia'];
            $ke_usia = $_POST['ke_usia'];
            $low_range = $_POST['low_range'];
           	//$disc_amount = $_POST['diskon'];
            $high_range = $_POST['high_range'];
           	$catatan = $_POST['catatan'];
           


		if (!isset($_POST['diskon']) || empty($_POST['diskon'])) {
				    $disc_amount = 'NULL';
				} else {
				    $disc_amount = "'" .pg_escape_string($_POST['diskon']) . "'";
				}
       
           $result=pg_query($dbconn,"UPDATE lab_analisis_referal_range SET 
				id_jenkel='".$gender."',
				usia_awal='".$dari_usia."',
				usia_akhir='".$ke_usia."',
				nilai_rendah='".$low_range."',
				nilai_tinggi='".$high_range."',
				catatan='$catatan'
				WHERE id = $id");

          

			if($res){
				echo "success";
			}
			else{
				echo "failed";
			}
			
			
			
			  
?>