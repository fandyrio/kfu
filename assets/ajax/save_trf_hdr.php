<?php 
			$proses_by 	= $_SESSION['id_users'];	
            $doc_no = $_POST['doc_no'];
            $doc_date = DateToDatabase ($_POST['tgl']);          
            $unit = $_POST['unit'];
            $ke_unit = $_POST['id_unit_to'];
            $id_departemen = $_POST['id_departemen'];
            $ke_departemen = $_POST['id_departemen_to'];
            $status = $_POST['status'];
            $refno = $_POST['refno'];  
            $terms = $_POST['terms'];
            $attention_to = $_POST['attention'];
            $catatan = $_GET['catatan'];
            
            
    $res=pg_query($dbconn,"INSERT INTO stok_trf_hdr (doc_no, doc_date, dari_unit, ke_unit, dari_departemen, ke_departemen, status, refno, catatan, id_users, createddate, attention_to,terms,  proses_date) 
			VALUES(
			'".$doc_no."',
			'".$doc_date."',		
			'".$unit."',
			'".$ke_unit."',
			'".$id_departemen."',
			'".$ke_departemen."',
			'".$status."',
			'$refno',
			'$catatan',
			'".$proses_by."',
			'".date('Y-m-d')."',
			'$attention_to',
			'$terms',
			'".date('Y-m-d')."'
			) RETURNING id");


    var_dump("INSERT INTO stok_trf_hdr (doc_no, doc_date, dari_unit, ke_unit, dari_departemen, ke_departemen, status, refno, catatan, id_users, createddate, attention_to,terms,  proses_date) 
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
      '".date('Y-m-d')."'
      ) RETURNING id");


		 $row = pg_fetch_row($res);


			if($res){
  

      $ln =pg_query($dbconn,"UPDATE stok_trf_ln SET id_hdr='".$row[0]."', id_users=NULL WHERE id_users = '".$_SESSION['id_users']."' ");          
            
      $batch=pg_query($dbconn,"UPDATE stok_trf_batch SET id_hdr='".$row[0]."', id_users=NULL WHERE id_users = '".$_SESSION['id_users']."' ");

    
                  


			$query=pg_query($dbconn,"select stok_trf_hdr.*, stok_trf_ln.id_inv, stok_trf_ln.id_satuan, stok_trf_batch.qty, stok_trf_ln.id as \"id_ln\", stok_trf_ln.total_cost, stok_trf_batch.no_batch, stok_trf_batch.dari_id_hdr, stok_trf_batch.dari_id_ln, stok_trf_batch.dari_id_batch,
        stok_trf_batch.id as \"id_trf_batch\" from stok_trf_hdr 
        INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
        INNER JOIN stok_trf_batch on stok_trf_batch.id_hdr = stok_trf_hdr.id and stok_trf_batch.id_ln = stok_trf_ln.id
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
    
     

  			

      }
     // $result=pg_query($dbconn,"DElete from stok_trf_ln_temp where id_users='".$_SESSION['id_users']."'");
     // $result=pg_query($dbconn,"DElete from stok_trf_batch_temp where id_users='".$_SESSION['id_users']."'");

    }

        		
			  
?>