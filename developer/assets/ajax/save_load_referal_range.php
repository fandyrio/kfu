<?php 

			$id_users = $_SESSION['id_users'];


            $gender = $_POST['id_gender'];
            $dari_usia = $_POST['dari_usia'];
            $ke_usia = $_POST['ke_usia'];
            $low_range = $_POST['low_range'];
           	//$disc_amount = $_POST['diskon'];
            $high_range = $_POST['high_range'];
           	$catatan = $_POST['catatan'];
           


				if (!isset($_SESSION['id_lab']) || empty($_SESSION['id_lab'])) {
				    $id_lab = 'NULL';
				} else {
				    $id_lab = "'" .pg_escape_string($_SESSION['id_lab']) . "'";
				}
       
            
           $res=pg_query($dbconn,"INSERT INTO 
		   lab_analisis_referal_range (id_lab_analisis,id_users,id_jenkel, usia_awal, usia_akhir,
		   nilai_rendah, nilai_tinggi, catatan) 
			VALUES(
				$id_lab,
			'".$id_users."',
			'".$gender."',
			'".$dari_usia."',
			'".$ke_usia."',
			'".$low_range."',			
			'".$high_range."',
			'$catatan')
			");


			if($res){
				echo "success";
			}
			else{
				echo "failed";
			}
			
			
			
			  
?>