 <?php        


            $doc_date = $_POST['doc_date'];
            $id_supplier = $_POST['id_supplier'];
            $catatan = $_POST['catatan'];
            $status = $_POST['status'];
            $islock = (isset($_POST['islock'])?1:0); 
            //$id = $_SESSION['id_users'];
  			$id = $_POST['id'];
  			

            $res=pg_query($dbconn,"UPDATE rq_hdr set doc_date='".$doc_date."', catatan='".$catatan."', id_supplier='".$id_supplier."', status='".$status."', islock='".$islock."' WHERE id = $id");

             unset($_SESSION['id_rq_hdr']);
    
		   /**/
?>  