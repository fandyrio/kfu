<?php 
            $id_trf_hdr = $_POST['id_trf_hdr'];   
            $doc_date = $_POST['tgl'];      
            $status = $_POST['status'];
            $refno = $_POST['refno'];  
            $terms = $_POST['terms'];
            $attention_to = $_POST['attention'];
            $catatan = $_GET['catatan'];
            
            
            $res=pg_query($dbconn,"UPDATE stok_trf_hdr set 
                    doc_date='".$doc_date."', 
                    refno='$refno', 
                    catatan='$catatan',  
                    attention_to= '$attention_to',
                    terms='$terms'  
                    WHERE id='".$id_trf_hdr."'
                    ");


             $row = pg_fetch_row($res);


        if($res){

        $ln =pg_query($dbconn,"UPDATE stok_trf_ln SET  id_users=NULL WHERE id_users = '".$_SESSION['id_users']."' AND id_hdr='".$id_trf_hdr."' ");          
              
        $batch=pg_query($dbconn,"UPDATE stok_trf_batch SET  id_users=NULL WHERE id_users = '".$_SESSION['id_users']."' AND id_hdr='".$id_trf_hdr."'  ");

      
                    


        $query=pg_query($dbconn,"select stok_trf_hdr.*, stok_trf_ln.id_inv, stok_trf_ln.id_satuan, stok_trf_batch.qty, stok_trf_ln.id as \"id_ln\", stok_trf_ln.total_cost, stok_trf_batch.no_batch, stok_trf_batch.dari_id_hdr, stok_trf_batch.dari_id_ln, stok_trf_batch.dari_id_batch,
          stok_trf_batch.id as \"id_trf_batch\" from stok_trf_hdr 
          INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
          INNER JOIN stok_trf_batch on stok_trf_batch.id_hdr = stok_trf_hdr.id and stok_trf_batch.id_ln = stok_trf_ln.id
                                                        Where stok_trf_hdr.id='".$id_trf_hdr."'");


   

                    
        while ($data=pg_fetch_assoc($query)) { 


        /*INSERT INTO ALOKASI */

          $alokasi= pg_query($dbconn, "select * from inv_alokasi where dari_id_hdr='".$data['dari_id_hdr']."' and dari_id_ln='".$data['dari_id_ln']."' AND dari_id_batch='".$data['dari_id_batch']."' 
            AND ke_id_hdr='".$data['id']."' AND ke_id_ln='".$data['id_ln']."' AND ke_id_batch='".$data['id_trf_batch']."'
                   " );

    


                if($jlh=pg_num_rows($alokasi)<=0){

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

                  

      }

    }

                  
                    
?>