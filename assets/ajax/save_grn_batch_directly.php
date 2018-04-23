<?php


			$id_users 	= $_SESSION['id_users'];
			$id_ln  	= $_SESSION['id_grn_ln'];
			$qty 		= $_POST['qty'];
			$no_batch 	= $_POST['no_batch'];
			$id_satuan 	= $_POST['id_satuan'];
			$nama_brand = $_POST['nama_brand'];
			$expired_date = DateToDatabase($_POST['expired_date']);
			//$manufacdate = DateToDatabase($_POST['manufacdate']);

			if (!isset($_POST['manufacdate']) || empty($_POST['manufacdate'])) {
				$manufacdate='NULL';
			}
			else{
				 $manufacdate = "'" .pg_escape_string(DateToDatabase($_POST['manufacdate'])) . "'";
			}

            if (!isset($_POST['catatan']) || empty($_POST['catatan'])) {
				    $catatan = 'NULL';
			} 
			else{
				    $catatan = "'" .pg_escape_string($_POST['catatan']) . "'";
			}
			
           
           if($_SESSION['id_grn_hdr']){
           	 $string_sql = "INSERT INTO 
			   grn_batch (
			   id_users,
			   qty, 
			   id_satuan, 
			   nama_brand,
			   no_batch,
			   expired_date,
			   manufacdate,
			   catatan,
			   id_ln,
			   id_hdr
			   ) 
				VALUES(
				'".$id_users."',
				'".$qty."',
				'".$id_satuan."',
				'".$nama_brand."',
				'".$no_batch."',
				'".$expired_date."',
				$manufacdate,
				$catatan,
				'".$id_ln."',
				'".$$_SESSION['id_grn_hdr']."'
				)";

           }
           else{
           $string_sql = "INSERT INTO 
		   grn_batch (
		   id_users,
		   qty, 
		   id_satuan, 
		   nama_brand,
		   no_batch,
		   expired_date,
		   manufacdate,
		   catatan,
		   id_ln
		   ) 
			VALUES(
			'".$id_users."',
			'".$qty."',
			'".$id_satuan."',
			'".$nama_brand."',
			'".$no_batch."',
			'".$expired_date."',
			$manufacdate,
			$catatan,
			'".$id_ln."'
			)";
		}

		var_dump($string_sql);
          $res=pg_query($dbconn,$string_sql);
			

			if($res){
				 
			unset($_SESSION['nama_brand']);
			unset($_SESSION['id_satuan']);
			unset($_SESSION['id_grn_ln']);
			
				echo "success";
			}
			else{
				echo "failed".$string_sql;
			}	
?>