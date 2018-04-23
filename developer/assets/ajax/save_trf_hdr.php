<?php 
			$proses_by 	= $_SESSION['id_users'];	
            $doc_no = $_POST['doc_no'];
            $doc_date = $_POST['tgl'];          
            $unit = $_POST['unit'];
            $ke_unit = $_POST['id_unit_to'];
            $id_departemen = $_POST['id_departemen'];
            $ke_departemen = $_POST['id_departemen_to'];
            $status = $_POST['status'];
            $refno = $_POST['refno'];  
            $terms = $_POST['terms'];
            $attention_to = $_POST['attention'];
            $catatan = $_GET['catatan'];
            
            
           $res=pg_query($dbconn,"INSERT INTO stok_trf_hdr (doc_no, doc_date, dari_unit, ke_unit, dari_departemen, ke_departemen, status, refno, catatan, id_users, createddate, attention_to,terms, proses_by, proses_date) 
			VALUES(
			'".$doc_no."',
			'".$doc_date."',		
			'".$unit."',
			'".$ke_unit."',
			'".$id_departemen."',
			'".$ke_departemen."',
			'".$status."',
			'".$refno."',
			'".$catatan."',
			'".$proses_by."',
			'".date('Y-m-d')."',
			'".$attention_to."',
			'".$terms."',
			'".$proses_by."',
			'".date('Y-m-d')."'
			) RETURNING id");

		
		 $row = pg_fetch_row($res);

			if($res){
  					$result=pg_query($dbconn,"INSERT INTO stok_trf_ln (id_trf_hdr,id_inv, nama_brand, qty, catatan, with_batch,total_cost, id_satuan, id_ln)

  											SELECT $row[0], id_inv,nama_brand, qty, catatan, with_batch,total_cost, id_satuan, id

  											FROM stok_trf_ln_temp
  											WHERE id_users = '".$_SESSION['id_users']."'");

  			$result=pg_query($dbconn,"INSERT INTO stok_trf_batch (id_ln,id_trf_batch,no_batch,tgl_expired, tgl_manufac, qty, id_satuan, catatan,id_users,createddate, total_cost, dari_id_hdr, dari_id_ln, dari_id_batch, id_trf_hdr)
  				 	SELECT id_ln,id, no_batch,tgl_expired, tgl_manufac,qty, id_satuan, catatan, '".$_SESSION['id_users']."',createddate, total_cost, dari_id_hdr, dari_id_ln, dari_id_batch,$row[0]
  											FROM stok_trf_batch_temp
  											WHERE id_users = '".$_SESSION['id_users']."'");


			$query=pg_query($dbconn,"select stok_trf_hdr.*, stok_trf_ln.id_inv, stok_trf_ln.id_satuan, stok_trf_ln.qty, stok_trf_ln.id_ln,stok_trf_ln.total_cost, stok_trf_batch.no_batch, stok_trf_batch.dari_id_hdr, stok_trf_batch.dari_id_ln, stok_trf_batch.dari_id_batch,
        stok_trf_batch.id_trf_batch from stok_trf_hdr 
        INNER JOIN stok_trf_ln on stok_trf_ln.id_trf_hdr = stok_trf_hdr.id
				  					INNER JOIN stok_trf_batch on stok_trf_batch.id_trf_hdr = stok_trf_hdr.id
				  					Where stok_trf_hdr.id='".$row[0]."'");

			while ($data=pg_fetch_assoc($query)) {
        /*INSERT INTO ALOKASI */
        pg_query($dbconn,"INSERT INTO inv_alokasi (ke_id_hdr,ke_doc_no,ke_id_ln, ke_id_batch, dari_id_hdr,dari_id_ln, dari_id_batch, base_qty, id_satuan, doc_type, total_cost) 
                    VALUES(
                    '".$data['id']."',
                    '".$data['doc_no']."',
                    '".$data['id_ln']."',
                    '".$data['id_trf_batch']."',
                    '".$data['dari_id_hdr']."',
                    '".$data['dari_id_ln']."',
                    '".$data['dari_id_batch']."',
                    '".$data['qty']."',
                    '".$data['id_satuan']."',   
                    'TRF',
                    '".$data['total_cost']."'
                                    
                    ) ");
        var_dump("INSERT INTO inv_alokasi (ke_id_hdr,ke_doc_no,ke_id_ln, ke_id_batch, dari_id_hdr,dari_id_ln, dari_id_batch, base_qty, id_satuan, doc_type, total_cost) 
                    VALUES(
                    '".$data['id']."',
                    '".$data['doc_no']."',
                    '".$data['id_ln']."',
                    '".$data['id_trf_batch']."',
                    '".$data['dari_id_hdr']."',
                    '".$data['dari_id_ln']."',
                    '".$data['dari_id_batch']."',
                    '".$data['qty']."',
                    '".$data['id_satuan']."',   
                    'TRF',
                    '".$data['total_cost']."') ");

                    /*INSERT INTO FIFO*/
                pg_query($dbconn,"INSERT INTO inv_fifo (id_hdr,doc_no,id_ln, id_batch, qty_out, cost_out, doc_type, id_inv) 
                            VALUES(
                            '".$data['id']."',
                            '".$data['doc_no']."',
                            '".$data['id_ln']."',
                            '".$data['id_trf_batch']."',
                            0,
                            0,     
                            'TRF',
                            '".$data['id_inv']."') "); 

                 
                 var_dump("INSERT INTO inv_fifo (id_hdr,doc_no,id_ln, id_batch, qty_out, cost_out, doc_type, id_inv) 
                            VALUES(
                            '".$data['id']."',
                            '".$data['doc_no']."',
                            '".$data['id_ln']."',
                            '".$data['id_trf_batch']."',
                            0,
                            0,     
                            'TRF',
                            '".$data['id_inv']."') ");            
                

                    

                pg_query($dbconn,"INSERT INTO inv_fifo (id_hdr,doc_no,id_ln, id_batch, qty_out, cost_out,doc_type, id_inv) 
                            VALUES(
                            '".$data['dari_id_hdr']."',
                            '".$data['doc_no']."',
                            '".$data['dari_id_ln']."',
                            '".$data['dari_id_hdr']."', 
                            '".$data['qty']."',
                            '".$data['total_cost']."',  
                            'TRF',
                            '".$data['id_inv']."') "); 

                var_dump("INSERT INTO inv_fifo (id_hdr,doc_no,id_ln, id_batch, qty_out, cost_out,doc_type, id_inv) 
                            VALUES(
                            '".$data['dari_id_hdr']."',
                            '".$data['doc_no']."',
                            '".$data['dari_id_ln']."',
                            '".$data['dari_id_hdr']."', 
                            '".$data['qty']."',
                            '".$data['total_cost']."',  
                            'TRF',
                            '".$data['id_inv']."') ") ;       	

  			}

  			$result=pg_query($dbconn,"DElete from stok_trf_ln_temp where id_users='".$_SESSION['id_users']."'");
  			$result=pg_query($dbconn,"DElete from stok_trf_batch_temp where id_users='".$_SESSION['id_users']."'");



				echo "success";

    }//end insert

        		
			  
?>