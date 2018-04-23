<?php


			$id_users 	= $_SESSION['id_users'];
			$id_hdr	= $_SESSION['id_grn_ln_temp'];
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
		   grn_batch (
		   qty, 
		   id_satuan, 
		   nama_brand,
		   no_batch,
		   expired_date,
		   manufacdate,
		   catatan,
		   id_grn_ln
		   ) 
			VALUES(
			'".$qty."',
			'".$id_satuan."',
			'".$nama_brand."',
			'".$no_batch."',
			'".$expired_date."',
			'".$manufacdate."',
			$catatan,
			'".$id_hdr."'
			)";
          $res=pg_query($dbconn,$string_sql);
			

			if($res){
			
				echo "success";
			}
			else{
				echo "failed".$string_sql;
			}	
?>