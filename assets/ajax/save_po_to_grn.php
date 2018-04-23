<?php

			$load_id_po 		= $_POST['load_id_po'];
			$nama_brand			= $_POST['nama_brand'];
			$id_users 			= $_SESSION['id_users']; 
			$qty 				= $_POST['po_qty'];
			$tgl_manufacture 	= $_POST['tgl_manufacture'];
			$tgl_expired 		= $_POST['tgl_expired']; 
			$no_batch			= $_POST['no_batch'];
			$satuan 			= $_POST['satuan'];

 					$result=pg_query($dbconn,"INSERT INTO grn_ln 
					( id_inv,nama_brand, qty, id_satuan,harga_unit, diskon_persen,diskon_amount,
					pajak_persen, pajak_amount,	id_po, nett_total,  id_users)
  					SELECT id_inv,nama_brand, jumlah, id_satuan, harga_unit, diskon_persen,diskon_amt,
					pajak_persen, pajak_amt, $load_id_po, nett_total, '".$id_users."' FROM po_ln WHERE id='".$load_id_po."'   RETURNING id");
          	
			
			if($result){
				$row = pg_fetch_row($result);
				$_SESSION['id_grn_ln_temp']    = $row[0];
				$_SESSION['jumlah_grn_temp']   = $qty;


				//save to batch
				 $string_sql = "INSERT INTO 
				   grn_batch (
				   id_users,
				   qty, 
				   id_satuan, 
				   nama_brand,
				   no_batch,
				   expired_date,
				   manufacdate,
				   id_ln
				   ) 
					VALUES(
					'".$id_users."',
					'".$qty."',
					'".$satuan."',
					'".$nama_brand."',
					'".$no_batch."',
					'".$tgl_expired."',
					'".$tgl_manufacture."',
					'".$_SESSION['id_grn_ln_temp']."'
					)";
		          	$res=pg_query($dbconn,$string_sql);
					if($res){
					
					
						echo "success";
					}
					else{
						echo "failed".$string_sql;
					}
				
			}
			else{
				echo "failed";
			}			  
?>