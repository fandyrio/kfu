<?php 
			$createdby 	= $_SESSION['id_users'];
			$id_supplier = $_POST['id_supplier'];
			$id_departemen = $_POST['id_departemen'];
            $doc_no = $_POST['doc_no'];
            $doc_date = $_POST['doc_date'];
            
            $attention_to = $_POST['ditujukan'];
            $shipping_address = $_POST['shipping_address'];
            $delivery_address = $_POST['delivery_address'];
            $status = $_POST['status'];
            $expected_date = $_POST['expected_date'];
            $tanggal_expire = $_POST['tanggal_expire'];
            $komentar = $_POST['komentar'];
            $refno = $_POST['refno'];
           
            
           $res=pg_query($dbconn,"INSERT INTO po_hdr (id_supplier, id_departemen, doc_no, doc_date, createddate, createdby, attention_to,shipping_address, delivery_address, status,expected_date, tanggal_expire, komentar, refno ) 
			VALUES(
			'".$id_supplier."',
			'".$id_departemen."',		
			'".$doc_no."',
			'".$doc_date."',
			'".date('Y-m-d')."',
			'".$createdby."',
			'".$attention_to."',
			'".$shipping_address."',
			'".$delivery_address."',
			'".$status."',
			'".$expected_date."',
			'".$tanggal_expire."',
			'".$komentar."',
			'".$refno."'
			) RETURNING id");
	

			 $row = pg_fetch_row($res);

				  if($res){
  					$result=pg_query($dbconn,"INSERT INTO po_ln (id_inv,nama_brand, jumlah, id_satuan, harga_unit, total_harga,komen, id_q ,diskon_persen,diskon_amt, pajak_persen, pajak_amt, nett_total, id_hdr)

  											SELECT id_inv,nama_brand, jumlah, id_satuan, harga_unit,total_harga,komen, id_q, diskon_persen,diskon_amt, pajak_persen, pajak_amt, nett_total, $row[0]

  											FROM po_ln_temp
  											WHERE id_users = '".$_SESSION['id_users']."'");
  					
				$result=pg_query($dbconn,"DElete from po_ln_temp where id_users='".$_SESSION['id_users']."'");

				echo "success";

        		}

        		
			  
?>