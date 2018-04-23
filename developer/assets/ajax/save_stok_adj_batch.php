<?php


			$id_users 	= $_SESSION['id_users'];
			$id_adj_ln = $_SESSION['id_adj_ln'];
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
		   stok_adj_batch_temp (
		   id_adj_ln,
		   no_batch,
		   qty, 
		   id_satuan,
		   expired_date,
		   catatan,
		   nama_brand,
		   manufacdate,
		   id_users
		   ) 
			VALUES(
			'".$id_adj_ln."',
			'".$no_batch."',
			'".$qty."',
			'".$id_satuan."',
			'".$expired_date."',
			$catatan,
			'".$nama_brand."',
			'".$manufacdate."',
			'".$id_users."'
			)";
          $res=pg_query($dbconn,$string_sql);

          

          var_dump($res);

          var_dump($string_sql);
			

			if($res){
				 
			unset($_SESSION['nama_brand']);
			unset($_SESSION['id_satuan']);
			unset($_SESSION['id_adj_ln']);
			
				echo "success";
			}
			else{
				echo "failed".$string_sql;
			}	
?>