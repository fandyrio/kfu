<?php 
			$doc_no 	= $_POST['doc_no'];
            $doc_date 	= $_POST['doc_date'];			
			$id_departemen	= $_POST['id_departemen'];			
			$id_unit	= 1;			
			$id_users	= $_SESSION['id_users'];
			$createddate = date('Y-m-d');
			$id_supplier	= $_POST['id_supplier'];
			$tgl_invoice = $_POST['tgl_invoice'];
			
			$catatan	= $_POST['catatan'];
			$status	= "A";
			           
            
           $res=pg_query($dbconn,"INSERT INTO retur_hdr (
		   doc_no,
		   doc_date,
		   id_departemen,
		   id_unit,
		   id_users,
		   catatan,
		   status,
		   createddate,
		   id_supplier
		   ) 
			VALUES(
			'".$doc_no."',
			'".$doc_date."',
			'".$id_departemen."',
			'".$id_unit."',
			'".$id_users."',
			'".$catatan."',
			'".$status."',
			'".$createddate."',
			'".$id_supplier."'
			) RETURNING id" );
	
			
			 $row = pg_fetch_row($res);
				//$id_hdr = $row[0];  

				//var_dump($id_hdr);

				  if($res){
  					$result=pg_query($dbconn,"INSERT INTO retur_ln
					(id_retur_ln, id_inv,nama_inventori, qty, id_satuan, id_retur_hdr,cost_unit,
					nett_cost
					)
  					SELECT id, id_inv,nama_brand, qty, id_satuan, $row[0], cost_unit, nett_cost
  											FROM retur_ln_temp
  											WHERE id_users = '".$_SESSION['id_users']."' RETURNING id");
  					//while ($row2= pg_fetch_row($result)) {
					$row2 = pg_fetch_row($result);
					var_dump($row2);
  					
					
					
					$result=pg_query($dbconn,"INSERT INTO retur_batch 
					( qty, id_satuan, id_retur_ln ,no_batch, tgl_expired,tgl_manufac,
						catatan
					)
  					SELECT qty, id_satuan, id_retur_ln ,no_batch, tgl_expired,tgl_manufac,
						catatan FROM retur_batch_temp
  											WHERE id_users = '".$_SESSION['id_users']."'");
					

					$result=pg_query($dbconn,"DElete from retur_batch_temp where id_users='".$_SESSION['id_users']."'");

				    $result=pg_query($dbconn,"DElete  from retur_ln_temp where id_users='".$_SESSION['id_users']."'" );
				    }
				    
        		

        		
			  
?>