<?php
	$id= $_GET["id"];
  $id_ln = $_GET["ln"];
  $id_batch = $_GET["bt"];

	$query=pg_query($dbconn,"select h.*, l.id_inv, l.id_satuan, b.qty, l.id as \"id_ln\", l.total_harga, b.no_batch, b.dari_id_hdr, b.dari_id_ln, b.dari_id_batch, b.dari_doc_type,
        b.id as \"id_adj_batch\" from stok_adj_hdr h
        INNER JOIN stok_adj_ln l on l.id_hdr = h.id 
        INNER JOIN stok_adj_batch b on b.id_hdr = h.id and b.id_ln = l.id 
		Where h.id='".$_GET["id"]."'");

	
		  
        while ($data=pg_fetch_assoc($query)) {               

        if($data['qty'] < 0 ){

          var_dump("minus");
                pg_query($dbconn,"Delete from inv_alokasi where dari_id_hdr='".$data['dari_id_hdr']."' and dari_id_ln='".$data['dari_id_ln']."' AND dari_id_batch='".$data['dari_id_batch']."' and ke_id_hdr='".$data['id']."' and ke_id_ln='".$data['id_ln']."' and ke_id_batch ='".$data['id_adj_batch']."' and doc_type='".$_data['dari_doc_type']."' ");

                $fifo= pg_query($dbconn, "select * from inv_fifo where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."'  AND doc_type='".$data['dari_doc_type']."' " );
                if($jlh=pg_num_rows($fifo)>0){

                    $fifetch = pg_fetch_array($fifo);
                    $qtynew= $fifetch["qty_out"] + $data['qty'];
                    $costnew = $fifetch["cost_out"] ;

                   	pg_query($dbconn,"update inv_fifo set qty_out='".$qtynew."' where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."'  AND doc_type='".$data['dari_doc_type']."' ");

                   $res=pg_query($dbconn,"DELETE FROM stok_adj_hdr WHERE id = '".$id."'");
                   $res=pg_query($dbconn,"DELETE FROM stok_adj_ln WHERE id_hdr = '".$id."'");
                   $res=pg_query($dbconn,"DELETE FROM stok_adj_batch WHERE id_hdr = '".$id."'");    
                }


            }  

       else{


                $fifo= pg_query($dbconn, "select sum(inv_fifo.qty_out) as jmlah from inv_fifo where id_hdr='".$data['id']."'  AND doc_type='ADJ' " );
                $jlh = pg_fetch_array($fifo);
                if($jlh['jmlah']=0){

		         	    pg_query($dbconn,"Delete from inv_fifo where  id_hdr='".$data['id']."' and doc_type='ADJ' "); 

                   $res=pg_query($dbconn,"DELETE FROM stok_adj_hdr WHERE id = '".$id."'");
                   $res=pg_query($dbconn,"DELETE FROM stok_adj_ln WHERE id_hdr = '".$id."'");
                   $res=pg_query($dbconn,"DELETE FROM stok_adj_batch WHERE id_hdr = '".$id."'"); 

		         }else{

                ?>
                <script>
                       alert("data sudah dipakai, tidak dapat dihapus");                 
                </script>
                <?php
              
             }
         }   


      
  			
      }
		
			?>
			<script>
      				document.location.href = "inventori-stok-adjustment";
				
			</script>
			<?php
			
  
?>