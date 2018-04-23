<?php 

			$id_inv 	= $_POST['id_inv'];
			$id_users 	= $_SESSION['id_users'];
			$qty 		= $_POST['qty'];
			$id_satuan 	= $_POST['id_satuan'];
			$nama_brand = $_POST['brand_nama'];
			$harga_unit = $_POST['harga_bersih'];
            if (!isset($_POST['diskon_persen']) || empty($_POST['diskon_persen'])) {
				    $diskon_persen = 'NULL';
			} 
			else{
				    $diskon_persen = "'" .pg_escape_string($_POST['diskon_persen']) . "'";
			}
			if (!isset($_POST['diskon_amount']) || empty($_POST['diskon_amount'])) {
				    $diskon_amount = 'NULL';
			} 
			else{
				    $diskon_amount = "'" .pg_escape_string($_POST['diskon_persen']) . "'";
			}
			if (!isset($_POST['pajak_persen']) || empty($_POST['pajak_persen'])) {
				    $pajak_persen = 'NULL';
			} 
			else{
				    $pajak_persen = "'" .pg_escape_string($_POST['pajak_persen']) . "'";
			}
			if (!isset($_POST['pajak_amount']) || empty($_POST['pajak_amount'])) {
				    $pajak_amount = 'NULL';
			} 
			else{
				    $pajak_amount = "'" .pg_escape_string($_POST['pajak_amount']) . "'";
			}
           
            
			$_SESSION['nama_brand']    = $nama_brand;
			$_SESSION['id_satuan']    = $id_satuan;
			$_SESSION['nama_satuan']    = $_POST['nama_satuan'];
            
           	//$disc_amount = $_POST['diskon'];
            
           	$nett_total = $_POST['nett_total'];
			$gross_total = $_POST['gross_total'];
           	$grand_total = 	$nett_total;
           $price = $_POST['harga_unit'];
           


 
            //$harga_unit = str_replace('.', '', $harga_unit);
            
          $res=pg_query($dbconn,"INSERT INTO 
		   grn_ln_temp (
		   id_inv,
		   qty, 
		   id_satuan, 
		   nama_brand,
		   harga_unit,
		   diskon_persen, 
		   diskon_amount, 
		   pajak_persen, 
		   pajak_amount, 
		   nett_total, 
		   gross_total,
		   id_users,
		   price,
		   grand_total
		   ) 
			VALUES(
			'".$id_inv."',
			'".$qty."',
			'".$id_satuan."',
			'".$nama_brand."',
			'".$harga_unit."',
			$diskon_persen,
			$diskon_amount,
			$pajak_persen,
			$pajak_amount,
			'".$nett_total."',
			'".$gross_total."',
			'".$id_users."',
			'".$price."',
			'".$grand_total."'
			) RETURNING id");

			
			if($res){
				$row = pg_fetch_row($res);
				$_SESSION['id_grn_ln_temp']    = $row[0];
				echo "success";
			}
			else{
				echo "failed";
			}			  
?>