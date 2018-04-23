<?php 
			$createdby 	= $_SESSION['id_users'];
            $tgl_dok 	= $_POST['tgl_dok'];     
			$no_dok	= $_POST['no_dok'];
			$validfrom	= $_POST['validfrom'];
			$validto	= $_POST['validto'];
			$catatan	= $_POST['catatan'];
			$id_supplier	= $_POST['id_supplier'];
			$promo	= (isset($_POST['promo'])?1:0);;
			$status	= $_POST['status'];
			$islock	= (isset($_POST['islock'])?1:0);;
           
            
           $res=pg_query($dbconn,"INSERT INTO q_hdr (createdby, tgl_dok, no_dok, validfrom, validto,catatan, id_supplier, promo,status,islock, createddate ) 
			VALUES(
			'".$createdby."',
			'".$tgl_dok."',
			'".$no_dok."',
			'".$validfrom."',
			'".$validto."',
			'".$catatan."',
			'".$id_supplier."',
			'".$promo."',
			'".$status."',
			'".$islock."',
			'".date('Y-m-d')."'
			) RETURNING id");
	
			
			
			var_dump($res);
			 $row = pg_fetch_row($res);
				//$id_hdr = $row[0];  

				//var_dump($id_hdr);

				  if($res){
  					$result=pg_query($dbconn,"INSERT INTO q_ln (id_inv,nama_brand, jumlah, id_satuan, id_hdr,harga_unit, disc_perc,disc_amount, net_price, bonus, base_unit_price, gross_total, net_total)
  											SELECT id_inv, nama_brand, jumlah, id_satuan, $row[0], harga_unit, disc_perc, disc_amount, net_price, bonus, base_unit_price, gross_total, net_total
  											FROM q_ln_temp
  											WHERE id_user = '".$_SESSION['id_users']."'");
  					
					$result=pg_query($dbconn,"DElete from q_ln_temp where id_user='".$_SESSION['id_users']."'");

				    //var_dump($result);
        		}

        		
			  
?>