<?php

			$id 		= $_POST['id'];
			$qty 		= $_POST['qty'];
			$expired_date = $_POST['expired_date'];
			$manufacdate = $_POST['manufacdate'];
			 $id_grn_ln_temp = $_POST['id_stok_buka_qty_temp']; 
            if (!isset($_POST['catatan']) || empty($_POST['catatan'])) {
				    $catatan = 'NULL';
			} 
			else{
				    $catatan = "'" .pg_escape_string($_POST['catatan']) . "'";
			}
			
           
            //$harga_unit = str_replace('.', '', $harga_unit);
           $string_sql = "UPDATE  
		   stok_buka_batch_temp SET 
		   qty ='".$qty."',
		   tgl_expired ='".$expired_date."',
		   manufacdate = '".$manufacdate."',
		   catatan = $catatan WHERE id='".$id."'";
          $res=pg_query($dbconn,$string_sql);
			

			if($res){
				 
				
				echo $id_grn_ln_temp;
			}
			else{
				echo "failed".$string_sql;
			}	
?>