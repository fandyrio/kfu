<?php 
			$id_users = $_SESSION['id_users'];
            $nama_brand = $_POST['brand_nama'];
            $jumlah = $_POST['jumlah'];
            $id_satuan = $_POST['id_satuan'];
           
            $harga_unit = $_POST['harga_unit'];
            $total_harga = $_POST['total_harga'];
            $komen = $_POST['komen'];
          
            if (!isset($_POST['diskon_persen']) || empty($_POST['diskon_persen'])) {
				    $diskon_persen = 'NULL';
				} else {
				    $diskon_persen = "'" . pg_escape_string($_POST['diskon_persen']) . "'";
				}


			 if (!isset($_POST['diskon_amt']) || empty($_POST['diskon_amt'])) {
				    $diskon_amt = 'NULL';
				} else {
				    $diskon_amt = "'" . pg_escape_string($_POST['diskon_amt']) . "'";
				}
				
				if (!isset($_POST['pajak_persen'] ) || empty($_POST['pajak_persen'])) {
				    $pajak_persen = 'NULL';
				} else {
				    $pajak_persen = "'" . pg_escape_string($_POST['pajak_persen']) . "'";
				}

				if (!isset($_POST['pajak_amt']) || empty($_POST['pajak_amt'])) {
				    $pajak_amt = 'NULL';
				} else {
				    $pajak_amt = "'" . pg_escape_string($_POST['pajak_amt']) . "'";
				}	
 
            $nett_total = $_POST['nett_total'];
            $id_inv = $_POST['id_inv'];

           
            
          $res=pg_query($dbconn,"INSERT INTO po_ln_temp (id_users,nama_brand, jumlah, id_satuan, harga_unit,total_harga, komen, diskon_persen, diskon_amt, pajak_persen, pajak_amt, nett_total, id_inv  ) 
			VALUES(
			'".$id_users."',
			'".$nama_brand."',
			'".$jumlah."',
			'".$id_satuan."',
			'".$harga_unit."',
			'".$total_harga."',
			'".$komen."',
			$diskon_persen ,
			$diskon_amt,
			$pajak_persen,
			$pajak_amt,
			'".$nett_total."',
			'".$id_inv."')
			");


			if($res){
				echo "success";
			}
			else{
				echo "failed";
			} 

			var_dump("INSERT INTO po_ln_temp (id_users,nama_brand, jumlah, id_satuan, harga_unit,total_harga, komen, diskon_persen, diskon_amt, pajak_persen, pajak_amt, nett_total, id_inv  ) 
			VALUES(
			'".$id_users."',
			'".$nama_brand."',
			'".$jumlah."',
			'".$id_satuan."',
			'".$harga_unit."',
			'".$total_harga."',
			'".$komen."',
			$diskon_persen ,
			$diskon_amt,
			$pajak_persen,
			$pajak_amt,
			'".$nett_total."',
			'".$id_inv."')
			");


			
			  
?>