<?php 


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
			
           
            
			$_SESSION['nama_brand']    = $nama_brand;
			$_SESSION['id_satuan']    = $id_satuan;
			$_SESSION['nama_satuan']    = $_POST['nama_satuan'];
            
           	//$disc_amount = $_POST['diskon'];
            
           	$totalcost = $_POST['total_cost'];
           


 
            //$harga_unit = str_replace('.', '', $harga_unit);
            
          $res=pg_query($dbconn,"INSERT INTO 
		   stok_buka_qty_temp (
		   id_inv,
		   qty, 
		   id_satuan, 
		   nama_brand,
		   harga_unit,
		   komentar,
		   totalcost,
		   id_users
		   ) 
			VALUES(
			'".$id_inv."',
			'".$qty."',
			'".$id_satuan."',
			'".$nama_brand."',
			'".$harga_unit."',
			$komentar,
			'".$totalcost."',
			'".$id_users."'
			) RETURNING id");

			
			if($res){
				$row = pg_fetch_row($res);
				$_SESSION['id_stok_buka_qty_temp']    = $row[0];
				echo "success";
			}
			else{
				echo "failed";
			}			  
?>