 <?php        
 
      $tgl_dok  = $_POST['tgl_dok'];     
      $validfrom  = $_POST['validfrom'];
      $validto  = $_POST['validto'];
      $catatan  = $_POST['catatan'];
      $id_supplier  = $_POST['id_supplier'];
      $promo  = (isset($_POST['promo'])?1:0);;
      $status = $_POST['status'];
      $islock = (isset($_POST['islock'])?1:0);;
  		$id = $_POST['id'];
  			

            $res=pg_query($dbconn,"UPDATE q_hdr set tgl_dok='".$tgl_dok."', validfrom='".$validfrom."', validto='".$validto."', id_supplier='".$id_supplier."',promo='".$promo."',catatan='".$catatan."', status='".$status."', islock='".$islock."' WHERE id = $id");

             unset($_SESSION['id_q_hdr']);
    
		   /*var_dump("UPDATE q_hdr set tgl_dok='".$tgl_dok."', validfrom='".$validfrom."', validto='".$validto."', id_supplier='".$id_supplier."',promo='".$promo."',catatan='".$catatan."', status='".$status."', islock='".$islock."' WHERE id = $id");*/
?>  