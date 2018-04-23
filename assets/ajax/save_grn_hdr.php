<?php

			$doc_no 	= $_POST['doc_no'];
            $doc_date 	= DateToDatabase($_POST['doc_date']);     
			//$id_departemen	= $_POST['id_departemen'];
			$id_departemen	= $_POST['id_departemen'];
			$id_supplier	= $_POST['id_supplier'];
			$id_unit		= $_POST['id_unit'];
			$credit_term	= $_POST['credit_term'];
			$no_invoice		= $_POST['no_invoice'];
			$tgl_invoice	= DateToDatabase($_POST['tgl_invoice']);
			$gross_total	= $_GET['gross_total'];
			$net_total	= $_GET['net_total'];
			$gl_no	= $_POST['gl_no'];

			$grand_total =0;
			$pajak =0;

			 if (!isset($_GET['disc_persen']) || empty($_GET['disc_persen'])) {
				    $disc_persen = 0;
				    $grand_total = 'nett_total';
			} 
			else{
				    $disc_persen = "'" .pg_escape_string($_GET['disc_persen']) . "'";
				    $grand_total = 'nett_total-(nett_total*'.$disc_persen.'/100)';
			}
			if (!isset($_GET['disc_amount']) || empty($_GET['disc_amount'])) {
				    $disc_amount = 0;
				     //$grand_total = 'nett_total';
			} 
			else{
				    $disc_amount = "'" .pg_escape_string($_GET['disc_amount']) . "'";
				    $grand_total = 'nett_total-'.$disc_amount;
			}
			if (!isset($_GET['pajak_persen']) || empty($_GET['pajak_persen'])) {
				    $pajak_persen = 0;
				    $pajak=0;
			} 
			else{
				    $pajak_persen = "'" .pg_escape_string($_GET['pajak_persen']) . "'";
				    $pajak = 'nett_total*'.$pajak_persen.')';
			}
			if (!isset($_GET['pajak_amount']) || empty($_GET['pajak_amount'])) {
				    $pajak_amount = 0;
				    //$pajak=0;
			} 
			else{
				    $pajak_amount = "'" .pg_escape_string($_GET['pajak_amount']) . "'";
				    $pajak = $pajak_amount;
			}
			$grand_total =$grand_total.'+'.$pajak;
           
            
          $res=pg_query($dbconn,"INSERT INTO grn_hdr (
		   doc_no,
		   doc_date,
		   id_departemen,
		   id_supplier,
		   id_unit,
		   credit_term,
		   no_invoice,
		   tgl_invoice,
		   gross_total,
		   net_total,
		   gl_no,
		   disc_persen,
		   disc_amount,
		   pajak_persen,
		   pajak_amount
		   ) 
			VALUES(
			'".$doc_no."',
			'".$doc_date."',
			'".$id_departemen."',
			'".$id_supplier."',
			'".$id_unit."',
			'$credit_term',
			'$no_invoice',
			'".$tgl_invoice."',
			'".$gross_total."',
			'".$net_total."',
			'$gl_no',
			'".$disc_persen."',
			'".$disc_amount."',
			'".$pajak_persen."',
			'".$pajak_amount."') RETURNING id" );

          var_dump("INSERT INTO grn_hdr (
		   doc_no,
		   doc_date,
		   id_departemen,
		   id_supplier,
		   id_unit,
		   credit_term,
		   no_invoice,
		   tgl_invoice,
		   gross_total,
		   net_total,
		   gl_no,
		   disc_persen,
		   disc_amount,
		   pajak_persen,
		   pajak_amount
		   ) 
			VALUES(
			'".$doc_no."',
			'".$doc_date."',
			'".$id_departemen."',
			'".$id_supplier."',
			'".$id_unit."',
			'$credit_term',
			'$no_invoice',
			'".$tgl_invoice."',
			'".$gross_total."',
			'".$net_total."',
			'$gl_no',
			'".$disc_persen."',
			'".$disc_amount."',
			'".$pajak_persen."',
			'".$pajak_amount."') RETURNING id");
	
			
			$row = pg_fetch_row($res);
				//$id_hdr = $row[0];  

				//var_dump($id_hdr);

				 if($res){
  					

				$resultz=pg_query($dbconn,"SELECT b.*, l.id_inv FROM grn_batch b inner join grn_ln l 
					ON l.id = b.id_ln  WHERE b.id_users = '".$_SESSION['id_users']."' ");
				 while ($r=pg_fetch_assoc($resultz)) {
					$fifo=pg_query($dbconn,"INSERT INTO inv_fifo 
					(id_hdr, id_ln, id_batch, doc_type,qty_out, cost_out, id_inv)
  					SELECT $row[0], id_ln, id, 'GRN', 0, 0, $r[id_inv] FROM grn_batch
  					WHERE id_users = '".$_SESSION['id_users']."' AND id='".$r['id']."' ");
  					
				}
				$ln_fix	=pg_query($dbconn,"UPDATE grn_ln SET id_hdr='".$row[0]."', id_users = NULL
  											WHERE id_users = '".$_SESSION['id_users']."' ");					
  					
					$batch_fix=pg_query($dbconn,"UPDATE grn_batch SET id_hdr='".$row[0]."', id_users = NULL
  											WHERE id_users = '".$_SESSION['id_users']."' ");

        		}
			  
?>