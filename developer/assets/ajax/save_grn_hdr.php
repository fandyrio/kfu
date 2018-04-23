<?php 
//var_dump($_GET);die;

			$doc_no 	= $_POST['doc_no'];
            $doc_date 	= $_POST['doc_date'];     
			//$id_departemen	= $_POST['id_departemen'];
			$id_departemen	= $_POST['id_departemen'];
			$id_supplier	= $_POST['id_supplier'];
			$id_unit	= $_POST['id_unit'];
			$credit_term	= $_POST['credit_term'];
			$no_invoice	= $_POST['no_invoice'];
			$tgl_invoice	= $_POST['tgl_invoice'];
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
			'".$credit_term."',
			'".$no_invoice."',
			'".$tgl_invoice."',
			'".$gross_total."',
			'".$net_total."',
			'".$gl_no."',
			'".$disc_persen."',
			'".$disc_amount."',
			'".$pajak_persen."',
			'".$pajak_amount."') RETURNING id" );
	
			
			$row = pg_fetch_row($res);
				//$id_hdr = $row[0];  

				//var_dump($id_hdr);

				 if($res){
  					$result=pg_query($dbconn,"INSERT INTO grn_ln 
					(id_grn_ln, id_inv,nama_brand, qty, id_satuan, id_grn_hdr,harga_unit, diskon_persen,diskon_amount,
					pajak_persen, pajak_amount,
					id_po, daripo, gross_total, nett_total,
					grand_total, price
					)
  					SELECT id, id_inv,nama_brand, qty, id_satuan, $row[0], harga_unit, diskon_persen,diskon_amount,
					pajak_persen, pajak_amount,
					id_po, daripo, gross_total, nett_total,
					$grand_total, price
  											FROM grn_ln_temp
  											WHERE id_users = '".$_SESSION['id_users']."' RETURNING id");
					$row2 = pg_fetch_row($result);
  					
					
					
					$result=pg_query($dbconn,"INSERT INTO grn_batch 
					(nama_brand, qty, id_satuan, id_grn_ln,no_batch, expired_date,manufacdate,
						catatan, id_grn_batch
					)
  					SELECT nama_brand, qty, id_satuan, id_grn_ln_temp,no_batch, expired_date,manufacdate,
						catatan,id		FROM grn_batch_temp
  											WHERE id_users = '".$_SESSION['id_users']."'");


				$resultz=pg_query($dbconn,"SELECT b.*, l.id_inv FROM grn_batch_temp b inner join grn_ln_temp l 
					ON l.id = b.id_grn_ln_temp  WHERE b.id_users = '".$_SESSION['id_users']."' ");
				 while ($r=pg_fetch_assoc($resultz)) {
					$fifo=pg_query($dbconn,"INSERT INTO inv_fifo 
					(id_hdr, id_ln, id_batch, doc_type,qty_out, cost_out, id_inv)
  					SELECT $row[0], id_grn_ln_temp, id, 'GRN', 0, 0, $r[id_inv] FROM grn_batch_temp
  					WHERE id_users = '".$_SESSION['id_users']."' AND id='".$r['id']."' ");
  					
				}


					/*
					SELECT b.*, l.id_inv FROM grn_batch_temp b
inner join grn_ln_temp l ON l.id = b.id_grn_ln_temp
 WHERE b.id_users = '6'

					*/

				  //  $result=pg_query($dbconn,"DElete  from grn_batch_temp where id_users='".$_SESSION['id_users']."'" );
				   // $result=pg_query($dbconn,"DElete from grn_ln_temp where id_users='".$_SESSION['id_users']."'");
        		}



    

  /*	var_dump("SELECT id, id_inv,nama_brand, qty, id_satuan, '1', harga_unit, diskon_persen,diskon_amount,
					pajak_persen, pajak_amount,
					id_po, daripo, gross_total, nett_total,
					$grand_total, price
  											FROM grn_ln_temp
  											WHERE id_users = '".$_SESSION['id_users']."' ");  	*/	
			  
?>