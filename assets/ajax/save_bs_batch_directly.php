<?php


			$id_users 	= $_SESSION['id_users'];
			$id_bs_ln_temp 	= $_SESSION['id_stok_buka_qty_temp'];
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
		   stok_buka_batch_temp (
		   id_users,
		   qty, 
		   id_satuan, 
		   no_batch,
		   tgl_expired,
		   manufacdate,
		   catatan,
		   id_stok_buka_qty_temp,
		   createddate
		   ) 
			VALUES(
			'".$id_users."',
			'".$qty."',
			'".$id_satuan."',
			'".$no_batch."',
			'".$expired_date."',
			'".$manufacdate."',
			$catatan,
			'".$id_bs_ln_temp."',
			'".date('Y-m-d')."'

			)";
          $res=pg_query($dbconn,$string_sql);
			

			if($res){
			
				echo "success";
			}
			else{
				echo "failed".$string_sql;
			}	
?>