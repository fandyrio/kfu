<?php 
			//$id_user = $_SESSION['id_users'];
            $brand_nama = $_POST['brand_nama'];
            $id_satuan = $_POST['id_satuan'];
            $jumlah = $_POST['jumlah'];
            $harga_unit = $_POST['harga'];
           	//$disc_amount = $_POST['diskon'];
            $gross_unit = $_POST['gross'];
           	$net_total = $_POST['net'];
            $net_price = $_POST['net_price'];
            $id_inv = $_POST['id_inv'];


			 if (!isset($_POST['diskon']) || empty($_POST['diskon'])) {
				    $disc_amount = 'NULL';
				} else {
				    $disc_amount = "'" .pg_escape_string($_POST['diskon']) . "'";
				}
            //$harga_unit = str_replace('.', '', $harga_unit);
            
           $res=pg_query($dbconn,"INSERT INTO 
		   q_ln (id_hdr,nama_brand, jumlah, id_satuan,
		   harga_unit, disc_amount, net_price, gross_total, net_total, id_inv ) 
			VALUES(
			'".$_SESSION['id_q_hdr']."',
			'".$brand_nama."',
			'".$jumlah."',
			'".$id_satuan."',
			'".$harga_unit."',
			$disc_amount,
			'".$net_price."',
			'".$gross_unit."',
			'".$net_total."',
			'".$id_inv."')
			");


			if($res){
				echo "success";
			}
			else{
				echo "failed";
			}
			
			/*var_dump("INSERT INTO 
		   q_ln (id_hdr,nama_brand, jumlah, id_satuan,
		   harga_unit, disc_amount, net_price, gross_total, net_total, id_inv ) 
			VALUES(
			'".$_SESSION['id_q_hdr']."',
			'".$brand_nama."',
			'".$jumlah."',
			'".$id_satuan."',
			'".$harga_unit."',
			$disc_amount,
			'".$net_price."',
			'".$gross_unit."',
			'".$net_total."',
			'".$id_inv."')
			");*/
			
			  
?>