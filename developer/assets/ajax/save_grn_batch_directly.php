<?php


			$id_users 	= $_SESSION['id_users'];
			$id_grn_ln_temp 	= $_SESSION['id_grn_ln_temp'];
			$qty 		= $_POST['qty'];
			$no_batch 	= $_POST['no_batch'];
			$id_satuan 	= $_POST['id_satuan'];
			$nama_brand = $_POST['nama_brand'];
			$expired_date = $_POST['expired_date'];
			$manufacdate = $_POST['manufacdate'];
            if (!isset($_POST['catatan']) || empty($_POST['catatan'])) {
				    $catatan = 'NULL';
			} 
			else{
				    $catatan = "'" .pg_escape_string($_POST['catatan']) . "'";
			}
			
           
            //$harga_unit = str_replace('.', '', $harga_unit);
           $string_sql = "INSERT INTO 
		   grn_batch_temp (
		   id_users,
		   qty, 
		   id_satuan, 
		   nama_brand,
		   no_batch,
		   expired_date,
		   manufacdate,
		   catatan,
		   id_grn_ln_temp
		   ) 
			VALUES(
			'".$id_users."',
			'".$qty."',
			'".$id_satuan."',
			'".$nama_brand."',
			'".$no_batch."',
			'".$expired_date."',
			'".$manufacdate."',
			$catatan,
			'".$id_grn_ln_temp."'
			)";
          $res=pg_query($dbconn,$string_sql);
			

			if($res){
				 
			unset($_SESSION['nama_brand']);
			unset($_SESSION['id_satuan']);
			unset($_SESSION['id_grn_ln_temp']);
			
				echo "success";
			}
			else{
				echo "failed".$string_sql;
			}	
?>