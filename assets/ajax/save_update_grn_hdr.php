<?php 
//var_dump($_GET);die;
			$id = $_POST['id'];
			$doc_no 	= $_POST['doc_no'];
            $doc_date 	= $_POST['doc_date'];     
			//$id_departemen	= $_POST['id_departemen'];
			$id_departemen	= 1;
			$id_supplier	= $_POST['id_supplier'];
			//$id_unit	= 1;
			$credit_term	= $_POST['credit_term'];
			//$no_invoice	= $_POST['no_invoice'];
			$tgl_invoice	= $_POST['tgl_invoice'];
			$gross_total	= $_GET['gross_total'];
			$net_total	= $_GET['net_total'];
			//$gl_no	= $_POST['gl_no'];

			if (!isset($_POST['no_invoice']) || empty($_POST['no_invoice'])) {
				    $no_invoice = 'NULL';
				   
			} 
			else{
				    $no_invoice = "'" .pg_escape_string($_POST['no_invoice']) . "'";
				   
			}

			 if (!isset($_POST['gl_no']) || empty($_POST['gl_no'])) {
				    $gl_no = 'NULL';
				   
			} 
			else{
				    $gl_no = "'" .pg_escape_string($_POST['gl_no']) . "'";
				   
			}
			 if (!isset($_GET['disc_persen']) || empty($_GET['disc_persen'])) {
				    $disc_persen = 0;
			} 
			else{
				    $disc_persen = "'" .pg_escape_string($_GET['disc_persen']) . "'";
			}
			if (!isset($_GET['disc_amount']) || empty($_GET['disc_amount'])) {
				    $disc_amount = 0;
			} 
			else{
				    $disc_amount = "'" .pg_escape_string($_GET['disc_amount']) . "'";
			}
			if (!isset($_GET['pajak_persen']) || empty($_GET['pajak_persen'])) {
				    $pajak_persen = 0;
			} 
			else{
				    $pajak_persen = "'" .pg_escape_string($_GET['pajak_persen']) . "'";
			}
			if (!isset($_GET['pajak_amount']) || empty($_GET['pajak_amount'])) {
				    $pajak_amount = 0;
			} 
			else{
				    $pajak_amount = "'" .pg_escape_string($_GET['pajak_amount']) . "'";
			}
           
            
           $res=pg_query($dbconn,"UPDATE grn_hdr set 
		    
		   credit_term ='".$credit_term."',
		   no_invoice= $no_invoice,
		   tgl_invoice ='".$tgl_invoice."',			
		   gross_total ='".$gross_total."',			
		   net_total= '".$net_total."',			
		   gl_no =$gl_no,
		   disc_persen ='".$disc_persen."',
		   disc_amount ='".$disc_amount."',
		  pajak_persen= '".$pajak_persen."',
			pajak_amount ='".$pajak_amount."' 
			where id = '".$id."' 
			"
			 );
			
			

				if($res){
  					echo "success";
  					$resultz=pg_query($dbconn,"SELECT b.*, l.id_inv FROM grn_batch b inner join grn_ln l 
					ON l.id = b.id_ln  WHERE b.id_hdr= '".$id."' ");
					 while ($r=pg_fetch_assoc($resultz)) {
					 	$fifo= pg_query($dbconn, "select * from inv_fifo where id_hdr='".$id."' and id_ln='".$r['id_ln']."' AND id_batch='".$r['id']."' AND doc_type='GRN'" );
		                if(pg_num_rows($fifo)==0){

		                   $insert_fifo=pg_query($dbconn,"INSERT INTO inv_fifo 
							(id_hdr, id_ln, id_batch, doc_type,qty_out, cost_out, id_inv) VALUES
		  					($id, $r['id_ln'], $r['id'], 'GRN', 0, 0, $r[id_inv])");
		  				} 
							
  					
					}
        		}else echo "gagal";

        		
			  
?>