 <?php        
 
            $createdby  = $_SESSION['id_users'];
            $id_supplier = $_POST['id_supplier'];
            $id_departemen = $_POST['id_departemen'];
            $doc_date = $_POST['doc_date'];
            
            $attention_to = $_POST['ditujukan'];
            $shipping_address = $_POST['shipping_address'];
            $delivery_address = $_POST['delivery_address'];
            $status = $_POST['status'];
            $expected_date = $_POST['expected_date'];
            $tanggal_expire = $_POST['tanggal_expire'];
            $komentar = $_POST['komentar'];
            $refno = $_POST['refno'];
            $id = $_POST['id'];
  			

            $res=pg_query($dbconn,"UPDATE po_hdr set doc_date='".$doc_date."', id_supplier='".$id_supplier."', id_departemen='".$id_departemen."', attention_to='".$attention_to."',shipping_address='".$shipping_address."',delivery_address='".$delivery_address."', status='".$status."', expected_date='".$expected_date."', tanggal_expire='".$tanggal_expire."', komentar='".$komentar."', refno='".$refno."' WHERE id = $id");

             unset($_SESSION['id_po_hdr']);

             if($res){
              echo "success";
             }else{
              echo "error";
             }
    
		  /* var_dump("UPDATE po_hdr set doc_date='".$doc_date."', id_supplier='".$id_supplier."', id_departemen='".$id_departemen."', attention_to='".$attention_to."',shipping_address='".$shipping_address."',delivery_address='".$delivery_address."', status='".$status."', expected_date='".$expected_date."', tanggal_expire='".$tanggal_expire."', komentar='".$komentar."', refno='".$refno."' WHERE id = $id");*/
?>  