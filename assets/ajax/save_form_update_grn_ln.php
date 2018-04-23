<?php 

			$id = $_POST['id'];
			$id_inv 	= $_POST['id_inv'];
			$id_users 	= $_SESSION['id_users'];
			$qty 		= $_POST['qty'];
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
           
            
            
           	//$disc_amount = $_POST['diskon'];
            
           	$nett_total = $_POST['nett_total'];
			$gross_total = $_POST['gross_total'];
           // $grand_total = $_POST['grand_total'];
          	$price = $_POST['harga_unit'];
           


 
            //$harga_unit = str_replace('.', '', $harga_unit);
            
           $res=pg_query($dbconn,"UPDATE 
		   grn_ln SET 		   
		   qty 			='".$qty."', 		  
		   harga_unit 	= '".$harga_unit."',
		   diskon_persen= $diskon_persen, 
		   diskon_amount= $diskon_amount,
		   pajak_persen = $pajak_persen, 
		   pajak_amount = $pajak_amount,
		   nett_total 	='".$nett_total."',
		   gross_total 	='".$gross_total."',
		   price		= '".$price."'
		   WHERE id = '".$id."'");

		   var_dump("UPDATE 
		   grn_ln SET 		   
		   qty 			='".$qty."', 		  
		   harga_unit 	= '".$harga_unit."',
		   diskon_persen= $diskon_persen, 
		   diskon_amount= $diskon_amount,
		   pajak_persen = $pajak_persen, 
		   pajak_amount = $pajak_amount,
		   nett_total 	='".$nett_total."',
		   gross_total 	='".$gross_total."',
		   price		= '".$price."'
		   WHERE id = '".$id."'");


			if($res){
				echo "success";
			}
			else{
				echo "failed";
			}
			
			
			  
?>