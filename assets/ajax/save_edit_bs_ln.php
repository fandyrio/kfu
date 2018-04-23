<?php


			$id 	= $_POST['id'];
			$id_inv 	= $_POST['id_inv'];
			$id_users 	= $_SESSION['id_users'];
			$qty 		= $_POST['qty'];
			$id_satuan 	= $_POST['id_satuan'];
			$nama_brand = $_POST['brand_nama'];
			$harga_unit = $_POST['harga_unit'];
            if (!isset($_POST['komentar']) || empty($_POST['komentar'])) {
				    $komentar = 'NULL';
			} 
			else{
				    $komentar = "'" .pg_escape_string($_POST['komentar']) . "'";
			}
			
           
                       
           	$totalcost = $_POST['total_cost'];
           


 
            //$harga_unit = str_replace('.', '', $harga_unit);
            
          $res=pg_query($dbconn,"UPDATE 
		   stok_buka_qty_temp set 
		   id_inv ='".$id_inv."',
		   qty 	 = '".$qty."',
		   id_satuan = '".$id_satuan."', 
		   nama_brand ='".$nama_brand."',
		   harga_unit = '".$harga_unit."',
		   komentar = $komentar,
		   totalcost ='".$totalcost."',
		   id_users ='".$id_users."'
		   WHERE id = '".$id."'"
		   );

			
			if($res){
						
				echo "success";
			}
			else{
				echo "failed";
			}			  
?>