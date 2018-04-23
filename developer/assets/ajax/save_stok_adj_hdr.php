<?php 
			$proses_by 	= $_SESSION['id_users'];	
            $doc_no = $_POST['doc_no'];
            $doc_date = $_POST['tgl_dok'];          
            $unit = $_POST['id_unit'];           
            $id_departemen = $_POST['id_departemen'];   
            $catatan = $_GET['catatan'];
            
            
           $res=pg_query($dbconn,"INSERT INTO stok_adj_hdr (doc_no,doc_date, id_unit, id_departemen, status,  createdby, createddate, catatan) 
			VALUES(
			'".$doc_no."',
			'".$doc_date."',		
			'".$unit."',
			'".$id_departemen."',
			'A',
			'".$proses_by."',
			'".date('Y-m-d')."',
			'".$catatan."'
			
			) RETURNING id");

		
		 $row = pg_fetch_row($res);

				  if($res){
  					$result=pg_query($dbconn,"INSERT INTO stok_adj_ln (id_adj_hdr,id_inv, nama_brand, qty, id_satuan, harga_unit,total_harga, loc_id,alasan, id_adj_ln)

  											SELECT $row[0], id_inv, nama_brand, qty, id_satuan, harga_unit,total_harga, loc_id,alasan, id

  											FROM stok_adj_ln_temp
  											WHERE id_users = '".$_SESSION['id_users']."'");
	
						 

		  				 $result=pg_query($dbconn,"INSERT INTO stok_adj_batch (id_adj_hdr, id_adj_ln, id_adj_batch,no_batch, qty, 
		  				 						id_satuan, expired_date, catatan, manufacdate,nama_brand, total_harga, dari_id_hdr, dari_id_ln, dari_id_batch)
		  											SELECT $row[0], id_adj_ln,id,no_batch, qty, id_satuan, expired_date, catatan, manufacdate,nama_brand,  total_harga,dari_id_hdr, dari_id_ln, dari_id_batch
		  											FROM stok_adj_batch_temp
		  											WHERE id_users = '".$_SESSION['id_users']."'");


		  				/**/

				  		$result=pg_query($dbconn,"select h.doc_no,l.id_inv, b.* from 
				  					stok_adj_hdr  h
									INNER JOIN stok_adj_ln  l on l.id_adj_hdr = h.id 
									INNER JOIN stok_adj_batch  b on b.id_adj_hdr = h.id and 
									b.id_adj_ln=l.id_adj_ln
							  				Where h.id='".$row[0]."'");

				  		/*var_dump("select h.doc_no,l.id_inv, b.* from 
				  					stok_adj_hdr  h
									INNER JOIN stok_adj_ln  l on l.id_adj_hdr = h.id 
									INNER JOIN stok_adj_batch  b on b.id_adj_hdr = h.id and 
									b.id_adj_ln=l.id_adj_ln
							  				Where h.id='".$row[0]."'");
*/
				  		While($data= pg_fetch_assoc($result)){

				  			if($data['qty'] < 0 ){

				  				pg_query($dbconn,"INSERT INTO inv_alokasi (ke_id_hdr,ke_doc_no,ke_id_ln, ke_id_batch, dari_id_hdr,dari_id_ln, dari_id_batch, base_qty, id_satuan, doc_type, total_cost) 
										VALUES(
										'".$data['id_adj_hdr']."',
										'".$data['doc_no']."',
										'".$data['id_adj_ln']."',
										'".$data['id_adj_batch']."',
										'".$data['dari_id_hdr']."',
										'".$data['dari_id_ln']."',
										'".$data['dari_id_batch']."',
										'".abs($data['qty'])."',
										'".$data['id_satuan']."',		
										'ADJ',
										'".$data['total_harga']."'
																		
										) ");
				  			}
				  			else{

				  				pg_query($dbconn,"INSERT INTO inv_fifo (id_hdr,doc_no,id_ln, id_batch, qty_out,cost_out,doc_type, id_inv) 
										VALUES(
										'".$data['id_adj_hdr']."',
										'".$data['doc_no']."',
										'".$data['id_adj_ln']."',
										'".$data['id_adj_batch']."',
										'0',
										'0',		
										'ADJ',
										'".$data['id_inv']."') ");

				  			}

				  		}		

 							$result=pg_query($dbconn,"DElete from stok_adj_ln_temp where id_users='".$_SESSION['id_users']."'");
		  					$result=pg_query($dbconn,"DElete from stok_adj_batch_temp where id_users='".$_SESSION['id_users']."'");
		  					$result=pg_query($dbconn,"DElete from inv_fiforeserve where id_users='".$_SESSION['id_users']."'");

					echo "success";

        		}

        		
			  
?>