<?php 
		$id = $_POST['id'];
			$id_inv 	= $_POST['id_inv'];
			$id_users 	= $_SESSION['id_users'];
			$qty 		= $_POST['qty'];
			$id_satuan 	= $_POST['id_satuan'];
			$nama_brand = $_POST['brand_nama'];
			$harga_unit = $_POST['harga_unit'];
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
           
            
            
           	//$disc_amount = $_POST['diskon'];
            
           	$nett_total = $_POST['nett_total'];
			$gross_total = $_POST['gross_total'];
           // $grand_total = $_POST['grand_total'];
           // $price = $_POST['price'];
           


 
            //$harga_unit = str_replace('.', '', $harga_unit);
            
           $res=pg_query($dbconn,"UPDATE 
		   grn_ln_temp SET 
		   id_inv 		= '".$id_inv."',
		   qty 			='".$qty."', 
		   id_satuan 	='".$id_satuan."', 
		   nama_brand 	='".$nama_brand."',
		   harga_unit 	= '".$harga_unit."',
		   diskon_persen= $diskon_persen, 
		   diskon_amount= $diskon_amount,
		   pajak_persen = $pajak_persen, 
		   pajak_amount = $pajak_amount,
		   nett_total ='".$nett_total."',
		   gross_total ='".$gross_total."',
		   id_users		= '".$id_users."'
		   WHERE id = '".$id."'");


			if($res){
				echo "success";
			}
			else{
				echo "failed";
			}
			
			
			  
?>