<?php 
//var_dump($_GET);die;

			$doc_no 	= $_POST['doc_no'];
            $doc_date 	= $_POST['doc_date'];			
			$id_departemen	= $_POST['id_departemen'];
			$loc_id	= 0;			
			//$id_unit	= 1;			
			$id_users 	= $_SESSION['id_users'];
			$createddate = date('Y-m-d');
			
			$komentar	= $_POST['komentar'];
			$status	= $_POST['status'];
			           
            
           $res=pg_query($dbconn,"INSERT INTO stok_buka_hdr (
				   doc_no,
				   doc_date,
				   id_departemen,
				   loc_id,		   
				   id_users,
				   komentar,
				   status,
				   createddate
				   ) 
					VALUES(
					'".$doc_no."',
					'".$doc_date."',
					'".$id_departemen."',
					'".$loc_id."',				
					'".$id_users."',			
					'".$komentar."',
					'".$status."',
					'".$createddate."'
					) RETURNING id" );
	
		
			
			 $row = pg_fetch_row($res);
				//$id_hdr = $row[0];  

				//var_dump($id_hdr);

				  if($res){
  					$result=pg_query($dbconn,"INSERT INTO stok_buka_qty 
					(id_inv,nama_brand, qty, id_satuan, id_buka_stok_hdr,harga_unit,
					totalcost, komentar, id_buka_stok_qty
					)
  					SELECT id_inv,nama_brand, qty, id_satuan, $row[0], harga_unit, totalcost, komentar, id
  											FROM stok_buka_qty_temp
  											WHERE id_users = '".$_SESSION['id_users']."'");
  					//while ($row2= pg_fetch_row($result)) {
					//$row2 = pg_fetch_row($result);

  									
					$data=pg_query($dbconn,"INSERT INTO stok_buka_batch 
					( qty, id_satuan, id_stok_buka_qty,no_batch, tgl_expired,tgl_manufac,
						catatan, id_users,createddate, id_stok_buka_hdr, id_stok_buka_batch
					)
  					SELECT qty, id_satuan, id_stok_buka_qty_temp,no_batch, tgl_expired,manufacdate,
						catatan, $id_users, createddate, $row[0],id FROM stok_buka_batch_temp
  											WHERE id_users = '".$_SESSION['id_users']."'");


				  		$result=pg_query($dbconn,"select h.doc_no,l.id_inv, b.* from 
				  					stok_buka_hdr  h
									INNER JOIN stok_buka_qty  l on l.id_buka_stok_hdr = h.id 
									INNER JOIN stok_buka_batch  b on b.id_stok_buka_hdr = h.id and 
									b.id_stok_buka_qty=l.id_buka_stok_qty
							  				Where h.id='".$row[0]."'");

				  		var_dump("select h.doc_no,l.id_inv, b.* from 
				  					stok_buka_hdr  h
									INNER JOIN stok_buka_qty  l on l.id_buka_stok_hdr = h.id 
									INNER JOIN stok_buka_batch  b on b.id_stok_buka_hdr = h.id and 
									b.id_stok_buka_qty=l.id_buka_stok_qty
							  				Where h.id='".$row[0]."'");

		
				  		While($data= pg_fetch_assoc($result)){


				  				pg_query($dbconn,"INSERT INTO inv_fifo (id_hdr,doc_no,id_ln, id_batch, qty_out,cost_out,doc_type, id_inv) 
										VALUES(
										'".$data['id_stok_buka_hdr']."',
										'".$data['doc_no']."',
										'".$data['id_stok_buka_qty']."',
										'".$data['id_stok_buka_batch']."',
										'0',
										'0',		
										'OPN',
										'".$data['id_inv']."') ");

				  		}	

				
						if($data){

							$result=pg_query($dbconn,"DElete from stok_buka_qty_temp where id_users='".$_SESSION['id_users']."'");

						    $result=pg_query($dbconn,"DElete  from stok_buka_batch_temp where id_users='".$_SESSION['id_users']."'" );
					    }
				    }
        		//}

        		
			  
?>