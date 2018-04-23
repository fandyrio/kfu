<?php 
			$proses_by 	= $_SESSION['id_users'];	
            $doc_no = $_POST['doc_no'];
            $doc_date = DateToDatabase($_POST['tgl_dok']);          
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
				'$catatan'			
				) RETURNING id");

		
		 $row = pg_fetch_row($res);

				  if($res){


		      $ln =pg_query($dbconn,"UPDATE stok_adj_ln SET id_hdr='".$row[0]."', id_users=NULL WHERE id_users = '".$_SESSION['id_users']."' ");          
		            
		      $batch=pg_query($dbconn,"UPDATE stok_adj_batch SET id_hdr='".$row[0]."', id_users=NULL WHERE id_users = '".$_SESSION['id_users']."' ");

  					
				  		$result=pg_query($dbconn,"select h.doc_no,l.id_inv, b.* from 
				  					stok_adj_hdr  h
									INNER JOIN stok_adj_ln  l on l.id_hdr = h.id 
									INNER JOIN stok_adj_batch  b on b.id_hdr = h.id and 
									b.id_ln=l.id
							  				Where h.id='".$row[0]."'");

				  		var_dump("select h.doc_no,l.id_inv, b.* from 
				  					stok_adj_hdr  h
									INNER JOIN stok_adj_ln  l on l.id_hdr = h.id 
									INNER JOIN stok_adj_batch  b on b.id_hdr = h.id and 
									b.id_ln=l.id
							  				Where h.id='".$row[0]."'");

				  		While($data= pg_fetch_assoc($result)){

				  			if($data['qty'] < 0 ){

				  				pg_query($dbconn,"INSERT INTO inv_alokasi (ke_id_hdr,ke_doc_no,ke_id_ln, ke_id_batch, dari_id_hdr,dari_id_ln, dari_id_batch, base_qty, id_satuan, doc_type, total_cost) 
										VALUES(
										'".$data['id_hdr']."',
										'".$data['doc_no']."',
										'".$data['id_ln']."',
										'".$data['id']."',
										'".$data['dari_id_hdr']."',
										'".$data['dari_id_ln']."',
										'".$data['dari_id_batch']."',
										'".abs($data['qty'])."',
										'".$data['id_satuan']."',		
										'ADJ',
										'".$data['total_harga']."'
																		
										) ");
				  				var_dump("INSERT INTO inv_alokasi (ke_id_hdr,ke_doc_no,ke_id_ln, ke_id_batch, dari_id_hdr,dari_id_ln, dari_id_batch, base_qty, id_satuan, doc_type, total_cost) 
										VALUES(
										'".$data['id_hdr']."',
										'".$data['doc_no']."',
										'".$data['id_ln']."',
										'".$data['id']."',
										'".$data['dari_id_hdr']."',
										'".$data['dari_id_ln']."',
										'".$data['dari_id_batch']."',
										'".abs($data['qty'])."',
										'".$data['id_satuan']."',		
										'ADJ',
										'".$data['total_harga']."'
																		
										) ");

				  				$fifo= pg_query($dbconn, "select * from inv_fifo where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."' AND doc_type='".$data['dari_doc_type']."'" );
				                if($jlh=pg_num_rows($fifo)>0){

				                	//$qty1 = explode("_", $data['qty']);

				                    $fifetch = pg_fetch_array($fifo);
				                    $qtynew= $fifetch["qty_out"] + abs($data['qty']);
				                     $costnew = $fifetch["cost_out"]+ $data['total_harga'] ;

				                   	pg_query($dbconn,"update inv_fifo set qty_out='".$qtynew."', cost_out='".$costnew."' where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."' AND doc_type='".$data['dari_doc_type']."' "); 

				                   	var_dump("update inv_fifo set qty_out='".$qtynew."', cost_out='".$costnew."' where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."' AND doc_type='".$data['dari_doc_type']."' ");

				                   	

				                }

							}

				  			else{

				  				pg_query($dbconn,"INSERT INTO inv_fifo (id_hdr,doc_no,id_ln, id_batch, qty_out,cost_out,doc_type, id_inv) 
										VALUES(
										'".$data['id_hdr']."',
										'".$data['doc_no']."',
										'".$data['id_ln']."',
										'".$data['id']."',
										'0',
										'0',		
										'ADJ',
										'".$data['id_inv']."') ");

				  			}

				  		}		

 							
		  		   $result=pg_query($dbconn,"DElete from inv_fiforeserve where id_users='".$_SESSION['id_users']."'");

					echo "success";

        		}

        		
			  
?>