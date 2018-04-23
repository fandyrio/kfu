<?php 
			$doc_no 	= $_POST['doc_no'];
            $doc_date 	= DateToDatabase($_POST['tgl_invoice']);	

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
				  	$ln =pg_query($dbconn,"UPDATE retur_ln SET id_hdr='".$row[0]."', id_users=NULL WHERE id_users = '".$_SESSION['id_users']."' ");          
				            
				    $batch=pg_query($dbconn,"UPDATE retur_batch SET id_hdr='".$row[0]."', id_users=NULL WHERE id_users = '".$_SESSION['id_users']."' ");

				    $query=pg_query($dbconn,"select retur_hdr.*, retur_ln.id_inv, retur_ln.id_satuan, retur_batch.qty, retur_ln.id as \"id_ln\", retur_ln.nett_cost, retur_batch.no_batch, retur_batch.dari_id_hdr, retur_batch.dari_id_ln, retur_batch.dari_id_batch,
        retur_batch.id as \"id_str_batch\" from retur_hdr 
        INNER JOIN retur_ln on retur_ln.id_hdr = retur_hdr.id
        INNER JOIN retur_batch on retur_batch.id_hdr = retur_hdr.id and retur_batch.id_ln = retur_ln.id
				  					Where retur_hdr.id='".$row[0]."'");
				  

   

			  
        while ($data=pg_fetch_assoc($query)) {               
        /*INSERT INTO ALOKASI */
                pg_query($dbconn,"INSERT INTO inv_alokasi (ke_id_hdr,ke_doc_no,ke_id_ln, ke_id_batch, dari_id_hdr,dari_id_ln, dari_id_batch, base_qty, id_satuan, doc_type, total_cost) 
                            VALUES(
                            '".$data['id']."',
                            '".$data['doc_no']."',
                            '".$data['id_ln']."',
                            '".$data['id_str_batch']."',
                            '".$data['dari_id_hdr']."',
                            '".$data['dari_id_ln']."',
                            '".$data['dari_id_batch']."',
                            '".$data['qty']."',
                            '".$data['id_satuan']."',   
                            'SR',
                            '".$data['nett_cost']."'                                           
                            ) ");

               


                	pg_query($dbconn,"update inv_fifo set qty_out=qty_out+'".$data['qty']."' where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."' AND doc_type='GRN' ");    
                	
                	 pg_query($dbconn,"Delete from inv_fiforeserve where id_users='".$_SESSION['id_users']."' ");  

  			

      	}
	 }
	 else{
	 	echo "INSERT INTO retur_hdr (
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
			) RETURNING id";
	 }
				    
        		

        		
			  
?>