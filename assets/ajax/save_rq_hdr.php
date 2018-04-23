 <?php
 session_start();
            $id_users = $_SESSION['id_users'];
            $doc_no = $_POST['doc_no'];
            $doc_date = DateToDatabase($_POST['doc_date']);
            $id_supplier = $_POST['id_supplier'];
            $catatan = $_POST['catatan'];
            $status = $_POST['status'];
            $islock = (isset($_POST['islock'])?1:0);
            //$tanggal = $_POST['tanggal'];
            //$created = $_POST['id_brand'];
            //$unit_id = $_POST['unit_id'];

            $res=pg_query($dbconn,"INSERT INTO rq_hdr (doc_no,doc_date, id_supplier, catatan, status, islock, tanggal, createdby, unit_id) VALUES('".$doc_no."','".$doc_date."'
              ,'".$id_supplier."'
              ,'$catatan'
              ,'".$status."'
              ,'".$islock."'
              ,'".date('Y-m-d')."'
              ,'".$id_users."'
              ,'$_SESSION[id_units]'
              ) RETURNING id ");  

            	/*ambil last id*/
               $row = pg_fetch_row($res);
				      // $id_rq = $row[0];  


				  if($res){
  					$res_ln=pg_query($dbconn,"INSERT INTO rq_ln (id_inv,nama_brand, jumlah, id_satuan, id_rq)
  											SELECT id_inv,nama_brand, jumlah, id_satuan, $row[0]
  											FROM rq_ln_temp
  											WHERE id_users = '".$_SESSION['id_users']."'");

           

  					$result=pg_query($dbconn,"DElete from rq_ln_temp where id_users='".$_SESSION['id_users']."'");

				    
        } 
		  
		 
?>  